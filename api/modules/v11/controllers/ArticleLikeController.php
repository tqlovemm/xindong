<?php
namespace api\modules\v11\controllers;


use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\helpers\Response;
use yii\db\Query;
use yii\myhelper\Decode;

class ArticleLikeController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\ArticleLike';
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
        header("Access-Control-Allow-Origin:".Yii::$app->params['hostname']);
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');
        $aid = Yii::$app->request->getBodyParam('aid');
        $uid = Yii::$app->request->getBodyParam('userid');
        $article = (new Query())->select('status')->from('{{%article_like}}')->where(['aid'=>$aid,"userid"=>$uid])->orderBy('created_at desc')->one();
        if($article){
            Response::show('202','点赞失败','已经点赞过了');
        }
        $model->status = 1;
        $dz = Yii::$app->db->createCommand("update {{%article}} set wdianzan=wdianzan+1 where id=$aid")->execute();
        if($dz){
            if($model->save()){
                Response::show('200','点赞成功','点赞成功');
            }else{
                Response::show('201','点赞失败','点赞失败');
            }
        }else{
            Response::show('201','点赞失败','点赞失败');
        }
    }
    public function actionDelete($id){
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确','参数不正确');
        }
        $model = new $this->modelClass();
        $aid = isset($_GET['aid'])?$_GET['aid']:'';
        $like = $model::find()->where(['aid'=>$aid,'userid'=>$id])->one();
        if(!$like){
            Response::show('202','操作失败','该数据不存在');
        }
        $res = $like->delete();
        $dz = Yii::$app->db->createCommand("update {{%article}} set wdianzan=wdianzan-1 where id=$aid")->execute();
        if(!$res){
            Response::show('201','操作失败','删除失败');
        }
        Response::show('200','操作成功','删除成功');
    }
}