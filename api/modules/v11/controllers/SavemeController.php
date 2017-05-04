<?php
namespace api\modules\v11\controllers;

use common\Qiniu\QiniuUploader;
use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\Pagination;
use yii\myhelper\Decode;
use api\modules\v11\models\SavemeInfo;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimiter;
use api\components\CsvDataProvider;

class SavemeController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\Saveme';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
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
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    public function actionIndex() {
        $uid = isset($_GET['uid'])?$_GET['uid']:'';
    	$model = $this->modelClass;
        $time = time();
        $where = "status > 0";
        $query = $model::find();
        $pagination = new Pagination([
            'defaultPageSize' => 10,
            'totalCount' => $query->count(),
        ]);
        $maxpage = ceil($pagination->totalCount/$pagination->defaultPageSize);
        $applyres = (new Query())->select('saveme_id')->from('{{%saveme_apply}}')->where(['apply_uid'=>$uid])->orderBy('created_at desc')->all();
        $savemeres = $query->orderBy('created_at desc')->where($where)->offset($pagination->offset)->limit($pagination->limit)->all();
        for ($i=0; $i < count($savemeres); $i++) { 
            if ($savemeres[$i]['end_time'] < $time) {
                $savemeres[$i]['status'] = 3;//已过期
            }
        }
        if ($applyres) {
            for ($i=0; $i < count($applyres); $i++) { 
                $savemeids[] = $applyres[$i]['saveme_id'];
            }
            for ($i=0; $i < count($savemeres); $i++) { 
                if (in_array($savemeres[$i]['id'],$savemeids)) {
                    $savemeres[$i]['status'] = 2;//已报名
                }
            }
        }
        if (!$savemeres) {
            return $this->datares(201,0,$savemeres,'not data!');
        }
        return $this->datares(200,$maxpage,$savemeres);
    }

    public function actionCreate() {
    	$model = new $this->modelClass();
    	$cid = Yii::$app->request->getBodyParam('created_id');
        $img = Yii::$app->request->getBodyParam('img');
    	$saveme = (new Query())->select('created_id,end_time,status')->from('{{%saveme}}')->where(['created_id'=>$cid])->orderBy('created_at desc')->one();
    	$time = time();
    	if ($saveme['status'] != 2 && $saveme['end_time'] > $time) {
    		Response::show('201','操作失败',"上一个救我还没结束");
    	}
        $userres = (new Query())->select('sex')->from('{{%user}}')->where(['id'=>$cid])->one();
        if ($userres['sex'] != 1) {
            Response::show('201','操作失败',"只有女生才能发布救火");
        }
    	$model->load(Yii::$app->request->getBodyParams(), '');
    	if($img){
    		$img = array_unique(array_filter(explode(";",Yii::$app->request->getBodyParam('img'))));
        }
    	$model->status = 1;
        $model->price = 98;
		if(!$model->save()){
			// return $model->getFirstErrors();
			Response::show('201','操作失败',"发布失败");
        }
        $insertid = Yii::$app->db->getLastInsertId();
        if ($img) {
        	for ($i=0; $i < count($img); $i++) { 
        		$photoname[] = "(".$insertid.",'".$this->UploadImg($img[$i],$model->created_id)."',"."1)";
        	}
            $sql = "INSERT INTO `pre_saveme_img` (`saveme_id`,`path`,`status`)  VALUES ".implode(",", $photoname);
	    	Yii::$app->db->createCommand($sql)->execute();
    	}
        Response::show('200','操作成功','发布成功');
    }
    //女生列表
    public function actionView($id) {
    	$model = new $this->modelClass();
        $query = $model::find()->where(['created_id'=>$id])->orderBy('created_at desc')->one();
        if (!$query) {
        	Response::show('201','操作失败','没有发布救火');
        }
        $saveme_id = $query['id'];
        $saveme_comment = (new Query())->select('to_userid')->from('{{%saveme_comment}}')->where(['saveme_id'=>$saveme_id,"created_id"=>$id])->orderBy('created_at desc')->one();
        $model2 = new SavemeInfo;
        $saveme_apply = $model2::find()->where(['and',['=','saveme_id',$saveme_id],['<>','type',2]])->orderBy('created_at desc')->all();
        for($i=0;$i<count($saveme_apply);$i++){
            if($saveme_apply[$i]['apply_uid'] == $saveme_comment['to_userid']){
                $saveme_apply[$i]['status'] = 3;
            }
        }
        if(!$saveme_apply){
            return $this->datares(201,0,$saveme_apply,'not data!');
        }
        return $this->datares(200,1,$saveme_apply);
    }
    //女生删除
    public function actionDelete($id) {
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确','参数不正确');
        }
        $did = isset($_GET['did'])?$_GET['did']:'';
        if ($did) {
            $applyres = (new Query())->select('id,apply_uid,status,type')->from('{{%saveme_apply}}')->where(['id'=>$did])->one();
            if ($applyres['type'] == 2) {
                Response::show(202,'删除失败','已经删除了');
            }
            if ($applyres['type'] == 1) {
                $res = Yii::$app->db->createCommand("delete form pre_saveme_apply where id = {$did}")->execute();
            }else{
                $res = Yii::$app->db->createCommand("update pre_saveme_apply set type = 2 where id = {$did}")->execute();
            }
        }else {
            $model = new SavemeInfo;
            $savemeres = (new Query())->select('id,status')->from('{{%saveme}}')->where(['created_id'=>$id])->all();
            for ($i=0; $i < count($savemeres); $i++) { 
                $sids[] = $savemeres[$i]['id'];
            }
            $applyres = (new Query())->select('id,saveme_id,apply_uid,status,type')->from('{{%saveme_apply}}')->where(['saveme_id'=>$sids])->all();
            for ($i=0; $i < count($applyres); $i++) { 
                if ($applyres[$i]['type'] == 1) {
                    $ids[] = $applyres[$i]['id'];
                }
                $sids[] = $applyres[$i]['saveme_id'];
            }
            if (isset($sids)) {
                $res = $model::updateAll(['type'=>2],['saveme_id'=>$sids]);
            }
            if (isset($ids)) {
                $res1 = $model::deleteAll(['in','id',$ids]);
            }
        }
        if(!($res || $res1)){
            Response::show('201','操作失败','删除失败');
        }
        Response::show('200','操作成功','删除成功');
    }

    protected function UploadImg($img,$user_id){
        $pre_url = Yii::$app->params['appimages'];
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $img = base64_decode($img);
        $path = '/uploads/saveme/';
        $savepath = Yii::getAlias('@apiweb').$path;
        $t = $user_id.'-'.uniqid().'.png';
        $savename = $savepath.$t;
        if(file_put_contents($savename,$img,FILE_USE_INCLUDE_PATH)){
            $qiniu = $qn->upload_app('appimages',$path.$t,$savename);
            return $pre_url.$qiniu['key'];
        }else{
            return "";
        }
    }

    protected function datares($code,$maxpage,$data,$message='ok'){
        $mess = $message;
        return array('code'=>$code,'message'=>$mess,'maxpage'=>$maxpage,'data'=>$data);
    }
}

