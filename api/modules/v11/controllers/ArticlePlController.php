<?php
namespace api\modules\v11\controllers;


use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\helpers\Response;
use yii\db\Query;

class ArticlePlController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\ArticlePl';
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
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }


    public function actionCreate()
    {
        header("Access-Control-Allow-Origin:http://api.13loveme.com:82");
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(),'');
        $aid = Yii::$app->request->getBodyParam('aid');
        $uid = Yii::$app->request->getBodyParam('created_id');
        $content = Yii::$app->request->getBodyParam('content');
        $article = (new Query())->select('status')->from('{{%article_comment}}')->where(['aid'=>$aid,"created_id"=>$uid,"content"=>$content])->orderBy('created_at desc')->one();
        if($article){
            Response::show('202','评论失败','不弄评论重复内容');
        }
        $model->status = 1;
        if($model->save()){
            Response::show('200','评论成功','评论成功');
        }else{
            Response::show('201','评论失败','评论失败');
        }
    }
}