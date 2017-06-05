<?php
namespace api\modules\v11\controllers;


use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use api\components\CsvDataProvider;
use yii\helpers\Response;
use yii\db\Query;
use yii\myhelper\Decode;

class ArticleCollectionController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\ArticleCollection';
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

    public function actionView($id) {
        $model = $this->modelClass;
        if(!$id){
            Response::show('201','获取失败','参数不全');
        }
        $where = ' status = 1 and userid = '.$id;
        $query = $model::find()->where($where)->orderBy('created_at desc');
        return new CsvDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }

    public function actionCreate()
    {
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');
        $aid = Yii::$app->request->getBodyParam('aid');
        $uid = Yii::$app->request->getBodyParam('userid');
        $article = (new Query())->select('status')->from('{{%article_collection}}')->where(['aid'=>$aid,"userid"=>$uid])->orderBy('created_at desc')->one();
        if($article){
            Response::show('202','收藏失败','已经在收藏列表中');
        }
        $model->status = 1;
        if($model->save()){
            Response::show('200','收藏成功','收藏成功');
        }else{
            Response::show('201','收藏失败','收藏失败');
        }
    }
    public function actionDelete($id){
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确','参数不正确');
        }
        $model = new $this->modelClass();
        $delall = isset($_GET['delall'])?$_GET['delall']:'';
        $cid = isset($_GET['cid'])?$_GET['cid']:'';
        Response::show('123',$cid,$cid);
//        if($delall){
//            $res = $model::deleteAll(['userid'=>$id]);
//        }else{
//            $Collection = $model::find()->where(['id'=>$cid,'userid'=>$id])->one();
//            if(!$Collection){
//                Response::show('202','操作失败','该数据不存在');
//            }
//            $res = $Collection->delete();
//        }
//        if(!$res){
//            Response::show('201','操作失败','删除失败');
//        }
//        Response::show('200','操作成功','删除成功');
    }
}