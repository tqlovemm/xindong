<?php
namespace api\modules\v11\controllers;

use common\Qiniu\QiniuUploader;
use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimiter;
class SavemeController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\Saveme';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    => 'items',
    ];

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                HttpBearerAuth::className(),
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
    	$model = $this->modelClass;
        $where = "status > 0";
        $query = $model::find()->where($where)->orderBy('created_at desc');
        //return $model::find()->where($where)->orderBy('created_at desc')->createCommand()->getRawSql();
        return new ActiveDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }

    public function actionCreate() {
    	$model = new $this->modelClass();
    	$cid = Yii::$app->request->getBodyParam('created_id');
        $img = Yii::$app->request->getBodyParam('img');
    	$saveme = (new Query())->select('created_id,end_time,status')->from('{{%saveme}}')->where(['created_id'=>$cid])->orderBy('created_at desc')->one();
    	$time = time();
    	if ($saveme['end_time'] > $time) {
    		Response::show('201','操作失败',"上一个救我还没结束");
    	}
    	$model->load(Yii::$app->request->getBodyParams(), '');
    	if($img){
    		$img = array_unique(array_filter(explode(";",Yii::$app->request->getBodyParam('img'))));
        }
        // return $img;
    	$model->created_at = time();
    	$model->updated_at = time();
    	$model->status = 1;
		if(!$model->save()){
			Response::show('201','操作失败',"发布失败");
        }
        $insertid = Yii::$app->db->getLastInsertId();
        if ($img) {
        	for ($i=0; $i < count($img); $i++) { 
        		$photoname[] = "(".$insertid.",'".$this->UploadImg($img[$i],$model->created_id)."',"."1)";
        	}
            $sql = "INSERT INTO `pre_saveme_img` (`saveme_id`,`path`,`status`)  VALUES ".implode(",", $photoname);
	    	$pid = Yii::$app->db->createCommand($sql)->execute();
    	}
        Response::show('200','操作成功','发布成功');
    }

    public function actionView($id) {
    	$model = new $this->modelClass();
        $query = $model::find()->where(['created_id'=>$id])->orderBy('created_at desc')->one();
        if ($query['status'] > 1) {
        	Response::show('201','操作失败','没有发布救火');
        }
        $saveme_id = $query['id'];
        $saveme_apply = (new Query())->from('{{%saveme_apply}}')->where(['saveme_id'=>$saveme_id])->orderBy('created_at desc');
        return new ActiveDataProvider(
            [
                'query' =>  $saveme_apply,
            ]
        );
    }

    protected function UploadImg($img,$user_id){
        $pre_url = Yii::$app->params['test'];
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $img = base64_decode($img);
        $path = '/uploads/saveme/';
        $savepath = Yii::getAlias('@apiweb').$path;
        $t = $user_id.'-'.uniqid().'.png';
        $savename = $savepath.$t;
        if(file_put_contents($savename,$img,FILE_USE_INCLUDE_PATH)){
            $qiniu = $qn->upload_app('test',$path.$t,$savename);
            return $pre_url.$qiniu['key'];
        }else{
            return "";
        }
    }
}

