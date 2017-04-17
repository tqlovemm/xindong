<?php
namespace api\modules\v11\controllers;

use api\modules\v11\models\FormThreadImages;
use api\modules\v2\models\Ufollow;
use common\Qiniu\QiniuUploader;
use yii;
use yii\rest\ActiveController;
use api\components\CsvDataProvider;
use yii\filters\RateLimiter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class FormThreadController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThread';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
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

    	$model = $this->modelClass;
        $getData = Yii::$app->request->get();
        $query =  $model::find()->where(['type'=>[0,1]]);

        if(!isset($getData['sex'])){
            $sex_filter = [0,1,2];
        }else{
            $sex_filter = [(integer)$getData,2];
        }
        $query =  $query->andWhere(['sex'=>$sex_filter]);

        if(isset($getData['follow'])){
            $follow = yii\helpers\ArrayHelper::map(Ufollow::findAll(['user_id'=>$getData['user_id']]),'people_id','people_id');
            $query =  $query->andWhere(['user_id'=>$follow]);
        }

        return new CsvDataProvider([
            'query' =>  $query,
            'pagination' => [
                'pageSize' => 16,
            ],
            'insert'=> [
                'modelName'=>$model::find()->where('type=2'),
                'rank'=>1
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                    'is_top' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @return mixed
     * post 提交，必填字段，user_id,content,sex
     */
    public function actionCreate() {

        $pre_url = Yii::$app->params['test'];
    	$model = new $this->modelClass();
    	$model->load(Yii::$app->request->getBodyParams(), '');

        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }else{

            $images = array_filter(explode('@',$model->base64Images));
            if(!empty($images)){
                $query = new FormThreadImages();
                $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);

                foreach ($images as $image){

                    $path = '/uploads/user/form_thread/'.$model->user_id.'_'.uniqid('',true).'.png';
                    $savePath = Yii::getAlias('@apiweb').$path;

                    if(file_put_contents($savePath,base64_decode($image),FILE_USE_INCLUDE_PATH)){

                        $imgInfo = getimagesize($savePath);
                        $qiniu = $qn->upload_app('test',$path,$savePath);
                        $_query = clone $query;
                        $_query->thread_id = $model->wid;
                        $_query->img_path = $pre_url.$qiniu['key'];
                        $_query->img_width = $imgInfo[0];
                        $_query->img_height = $imgInfo[1];
                        if($_query->save()){
                            @unlink($savePath);
                        }else{
                            $_query->errors;
                        }
                    }
                }
            }
        }

        return $model;
    }

    public function actionView($id) {

        $model = $this->findModel($id);
        return $model;
    }

    public function actionDelete($id)
    {
       return $this->findModel($id)->delete();
    }

    protected function DeleteImg($imgs){
        $pre_url = Yii::$app->params['appimages'];
        $avatar_path = str_replace($pre_url,'',$imgs);
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qn->delete('appimages',$avatar_path);
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

}

