<?php
namespace api\modules\v11\controllers;

use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\myhelper\Decode;
use api\modules\v11\models\Saveme;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimiter;
class SavemeInfoController extends ActiveController {
    public $wcity = array('上海','北京','重庆','天津');
    public $modelClass = 'api\modules\v11\models\SavemeInfo';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    => 'items',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
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
    public function actionView($id) {
        $model = new $this->modelClass();
        $query = $model::find()->where(['apply_uid'=>$id])->orderBy('created_at desc');
        return new ActiveDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }
    public function actionCreate() {
        $model = new $this->modelClass();
        $model2 = new Saveme;
        $model->load(Yii::$app->request->getBodyParams(), '');
        $sid = $model->saveme_id;
        $aid = $model->apply_uid;
        if (!$sid) {
           Response::show('202','操作失败',"参数不全");
        }
        $saveme = $model2::find()->where(['id'=>$sid])->one();
        $jiecaocoin = (new Query())->select('jiecao_coin')->from('{{%user_data}}')->where(['user_id'=>$aid])->one();
        if($jiecaocoin['jiecao_coin'] < $saveme['price'] ){
            Response::show('201',"报名需{$saveme['price']}节操币，您的余额不足");
        }else {
            $jc = Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin=jiecao_coin-{$saveme['price']} where user_id=$aid")->execute();
            if (!$jc) {
                Response::show('201',"扣除节操币失败");
            }
        }
        $address = (new Query())->select('address')->from('{{%user_profile}}')->where(['user_id'=>$aid])->one();
        $user_address = explode(" ",$address['address']);
        $saveme_address = explode(" ",$saveme['address']);
        if (in_array($saveme_address[0],$this->wcity)) {
            if ($saveme_address[0] != $user_address[0]) {
                Response::show('202','操作失败',"用户城市与目标城市不符合1");
            }
        }else {
            if ($saveme['address'] != $address['address']) {
               Response::show('202','操作失败',"用户城市与目标城市不符合2");
            }
        }
        $time = time();
        if ($saveme && $time > $saveme['end_time']) {
            Response::show('201','操作失败',"该救火已过期");
        }
        $applyres = (new Query())->select('saveme_id,apply_uid,status')->from('{{%saveme_apply}}')->where(['saveme_id'=>$sid,'apply_uid'=>$aid])->orderBy('created_at desc')->one();
        if ($applyres) {
            Response::show('201','操作失败',"您已经申请过该救火");
        }
        $model->status = 0;
        if(!$model->save()){
            // return $model->getFirstErrors();
            Response::show('201','操作失败',"申请失败");
        }
        Response::show('200','操作成功',"申请成功");
    }
    public function actionUpdate($id) {
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new $this->modelClass();
        $apply_uid = Yii::$app->request->getBodyParam('apply_uid');
        $savemeres = (new Query())->select('id,created_id,price')->from('{{%saveme}}')->where(['created_id'=>$id,'status'=>1])->orderBy('created_at desc')->one();
        if (!$savemeres) {
            Response::show('201','操作失败',"参数不正确2");
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
        if (isset($uids)) {
            $uids = "(".substr($uids, 0,-1).")";
            $jc = Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin=jiecao_coin+{$savemeres['price']} where user_id in $uids")->execute();
        }
        if (!$res1) {
            Response::show('201','操作失败',"审核失败1");
        }
        $res2 = Yii::$app->db->createCommand("update pre_saveme_apply set status = 1 where saveme_id = {$saveme_id} and apply_uid = {$apply_uid}")->execute();
        if (!$res2) {
            Response::show('201','操作成功',"审核失败2");
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
}

