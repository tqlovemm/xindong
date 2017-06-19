<?php
namespace api\modules\v11\controllers;

use api\modules\v11\models\User;
use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\myhelper\Decode;
use api\modules\v11\models\Saveme;
use common\components\PushConfig;
use yii\filters\RateLimiter;
use yii\data\Pagination;
use common\components\SaveToLog;
use yii\base\Exception;
use yii\base\ErrorException;
class SavemeInfoController extends ActiveController {
    public $wcity = array('上海','北京','重庆','天津');
    public $modelClass = 'api\modules\v11\models\SavemeInfo';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();

        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }
    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }
    //男生通知列表
    public function actionView($id) {
        $model = new $this->modelClass();
        $query = $model::find()->where(['and',['=','apply_uid',$id],['<>','type',1]])->orderBy('created_at desc')->all();
        $sids = '';
        for ($i=0; $i < count($query); $i++) { 
            $sids[] = $query[$i]['saveme_id'];
            $statuss[$query[$i]['saveme_id']] = $query[$i]['status'];
        }
        $model2 = new Saveme;
        if(!$sids){
            return $this->datares(201,0,'not data!','not data!');
        }
        $save_query = $model2::find()->where(['id'=>$sids]);
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $save_query->count(),
        ]);
        $saveme_comment = (new Query())->select('saveme_id,to_userid')->from('{{%saveme_comment}}')->where(['saveme_id'=>$sids,"created_id"=>$id])->orderBy('created_at desc')->all();
        $maxpage = ceil($pagination->totalCount/$pagination->defaultPageSize);
        $res = $save_query->orderBy('created_at desc')->offset($pagination->offset)->limit($pagination->limit)->all();
        for ($k=0; $k < count($res); $k++) { 
            $res[$k]['status'] = $statuss[$res[$k]['id']];
            for($q=0;$q<count($saveme_comment);$q++){
                if($res[$k]['created_id'] == $saveme_comment[$q]['to_userid'] && $res[$k]['id'] == $saveme_comment[$q]['saveme_id']){
                    $res[$k]['status'] = 3;
                }
            }
        }
        if (!$res) {
            return $this->datares(201,0,$res,'not data!');
        }
        return $this->datares(200,$maxpage,$res);
    }
    public function actionCreate() {
        $model = new $this->modelClass();
        $model2 = new Saveme;
        $model->load(Yii::$app->request->getBodyParams(), '');
        $sid = $model->saveme_id;
        $aid = $model->apply_uid;
        if (!$sid) {
           Response::show('202','1',"参数不全");
        }
        $saveme = $model2::find()->where(['id'=>$sid])->one();
        $time = time();
        if ($saveme && $time > $saveme['end_time']) {
            Response::show('201','1',"该救火已过期");
        }
        $girlid = $saveme['created_id'];

        $address = (new Query())->select('address')->from('{{%user_profile}}')->where(['user_id'=>$aid])->one();
        $user_address = explode(" ",$address['address']);
        $saveme_address = explode(" ",$saveme['address']);
        if (in_array($saveme_address[0],$this->wcity)) {
            if ($saveme_address[0] != $user_address[0]) {
                Response::show('202','2',"用户城市与目标城市不符合");
            }
        }else {
            if ($saveme['address'] != $address['address']) {
               Response::show('202','2',"用户城市与目标城市不符");
            }
        }
        $applyres = (new Query())->select('saveme_id,apply_uid,status')->from('{{%saveme_apply}}')->where(['saveme_id'=>$sid,'apply_uid'=>$aid])->orderBy('created_at desc')->one();
        if ($applyres) {
            Response::show('201','1',"您已经申请过该救火");
        }
        $jiecaocoin = (new Query())->select('jiecao_coin')->from('{{%user_data}}')->where(['user_id'=>$aid])->one();
        if($jiecaocoin['jiecao_coin'] < $saveme['price'] ){
            Response::show('201','3',"报名需{$saveme['price']}心动币，您的余额不足");
        }else {
            $jc = Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin=jiecao_coin-{$saveme['price']} where user_id=$aid")->execute();
            try{
                SaveToLog::userBgRecord("报名救我花费{$saveme['price']}心动币",$aid);
            }catch (yii\base\Exception $e){
                throw new yii\base\ErrorException($e->getMessage());
            }
            if (!$jc) {
                Response::show('201','3',"扣除心动币失败");
            }
        }
        $model->status = 0;
        $model->type = 0;
        if(!$model->save()){
            // return $model->getFirstErrors();
            Response::show('201','1',"申请失败");
        }
        //推送
        $cid = Yii::$app->db->createCommand('select cid,username,nickname from {{%user}} where id='.$aid)->queryOne();
        if(!empty($girlid)){
            if(empty($cid['nickname'])){
                $cid['nickname'] = $cid['username'];
            }
            $title = $cid['nickname'].'申请了您发布的救我';
            $msg = $cid['nickname'].'申请了您发布的救我';
            $data = array('push_title'=>$title,'push_content'=>$msg,'push_post_id'=>"$aid",'push_type'=>'SSCOMM_SAVEME');
            $extras = json_encode($data);
            PushConfig::config();
            pushMessageToList(1, $title, $msg, $extras , [User::findOne($girlid)->cid]);
        }
        Response::show('200','操作成功',"申请成功");
    }
    public function actionUpdate($id) {
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        PushConfig::config();
        $model = new $this->modelClass();
        $cid = Yii::$app->db->createCommand('select cid,username,nickname from {{%user}} where id='.$id)->queryOne();
        $apply_uid = Yii::$app->request->getBodyParam('apply_uid');
        $savemeres = (new Query())->select('id,created_id,price,end_time')->from('{{%saveme}}')->where(['created_id'=>$id,'status'=>1])->orderBy('created_at desc')->one();
        if (!$savemeres) {
            Response::show('201','操作失败',"参数不对");
        }
        if ($savemeres['end_time'] < time()) {
            Response::show('201','操作失败',"本次救火已经过期");
        }
        $saveme_id = $savemeres['id'];
        $myapply = $model::find()->select('saveme_id,apply_uid,status')->where(['apply_uid'=>$apply_uid,'saveme_id'=>$saveme_id])->one();
        if (!$myapply) {
            Response::show('201','操作失败',"参数不正确3");
        }
        if ($myapply['status'] > 0) {
            Response::show('201','操作失败',"已经审核过了");
        }
        $res1 = Yii::$app->db->createCommand("update pre_saveme_apply set status = 2 where saveme_id = {$saveme_id}")->execute();
        $applyres = $model::find()->select('saveme_id,apply_uid')->where(['saveme_id'=>$saveme_id])->all();
        $uids = '';
        for ($i=0; $i < count($applyres); $i++) {
            if ($applyres[$i]['apply_uid'] != $apply_uid) {
                $uids .= $applyres[$i]['apply_uid'].",";
            }
        }
        if ($uids) {
            $uids = "(".substr($uids, 0,-1).")";
            Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin=jiecao_coin+{$savemeres['price']} where user_id in $uids")->execute();
            $uids = explode(",",substr($uids,1,-1));
            foreach ($uids as $v) {
                try{
                    SaveToLog::userBgRecord("救我被拒绝退回{$savemeres['price']}节操币",$v);
                }catch (Exception $e){
                    throw new ErrorException($e->getMessage());
                }
                //拒绝推送
                if(!empty($cid['cid'])){
                    if(empty($cid['nickname'])){
                        $cid['nickname'] = $cid['username'];
                    }

                    $title = $cid['nickname'].'拒绝了您的救我申请';
                    $msg = $cid['nickname'].'拒绝了您的救我申请';
                    $data = array('push_title'=>$title,'push_content'=>$msg,'push_post_id'=>"$id",'push_type'=>'SSCOMM_SAVEME');
                    $extras = json_encode($data);
                    $user_cid[] = User::findOne($v)->cid;
                }
            }
            pushMessageToList(1, $title, $msg, $extras , $user_cid);
        }
        if (!$res1) {
            Response::show('201','操作失败',"审核失败1");
        }
        $res2 = Yii::$app->db->createCommand("update pre_saveme_apply set status = 1 where saveme_id = {$saveme_id} and apply_uid = {$apply_uid}")->execute();
        if (!$res2) {
            Response::show('201','操作成功',"审核失败2");
        }
        //接收推送
        if(!empty($cid['cid'])){
            if(empty($cid['nickname'])){
                $cid['nickname'] = $cid['username'];
            }
            $title = $cid['nickname'].'通过了您的救我申请';
            $msg = $cid['nickname'].'通过了您的救我申请';
            $data = array('push_title'=>$title,'push_content'=>$msg,'push_post_id'=>"$id",'push_type'=>'SSCOMM_SAVEME');
            $extras = json_encode($data);
            pushMessageToList(1, $title, $msg, $extras , [User::findOne($apply_uid)->cid]);
        }
        $res3 = Yii::$app->db->createCommand("update pre_saveme set status = 2 where id = {$saveme_id}")->execute();
        if ($res3) {
            Response::show('200','操作成功',"审核成功");
        }
        Response::show('201','操作成功',"审核失败3");
    }
    public function actionDelete($id) {
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确','参数不正确');
        }
        $did = isset($_GET['did'])?$_GET['did']:'';
        if ($did) {
            $applyres = (new Query())->select('id,apply_uid,status,type')->from('{{%saveme_apply}}')->where(['id'=>$did])->one();
            if ($applyres['type'] == 2) {
                $res = Yii::$app->db->createCommand("delete form pre_saveme_apply where id = {$did}")->execute();
            }else{
                $res = Yii::$app->db->createCommand("update pre_saveme_apply set type = 1 where id = {$did}")->execute();
            }
        }else {
            $model = new $this->modelClass();
            $applyres = (new Query())->select('id,apply_uid,status,type')->from('{{%saveme_apply}}')->where(['apply_uid'=>$id])->all();
            for ($i=0; $i < count($applyres); $i++) { 
                if ($applyres[$i]['type'] == 2) {
                    $ids[] = $applyres[$i]['id'];
                }
            }
            if (isset($ids)) {
                $res1 = $model::deleteAll(['in','id',$ids]);
            }
            $res = $model::updateAll(['type'=>1],['apply_uid'=>$id]);
        }
        if(!($res || $res1)){
            Response::show('201','操作失败','删除失败');
        }
        Response::show('200','操作成功','删除成功');
    }
    protected function datares($code,$maxpage,$data,$message='ok'){
        $mess = $message;
        return array('code'=>$code,'message'=>$mess,'maxpage'=>$maxpage,'data'=>$data);
    }
}

