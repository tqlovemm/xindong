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

    public function actionIndex()
    {
        header("Access-Control-Allow-Origin:".Yii::$app->params['hostname']);
        $aid = intval($_GET['aid']);
        if(empty($aid)){
            Response::show('202','not','not data!');
        }
        $res = (new Query())->select('c.id,c.content,c.created_at,u.username,u.nickname,u.avatar')->from('{{%article_comment}} AS c')->leftJoin('{{%user}} AS u','u.id = c.created_id')->limit(1)->orderby('created_at desc')->where("aid = $aid")->all();
        $time = time();
        for($i=0;$i<count($res);$i++){
            if(!$res[$i]['nickname']){
                $res[$i]['nickname'] = $res[$i]['username'];
            }
            $res[$i]['time'] = $time-$res[$i]['created_at'];
            if($res[$i]['time'] >= 24*3600){
                $res[$i]['time'] = date('Y-m-d',$res[$i]['created_at']);
            }else{
                if($res[$i]['time'] >= 3600){
                    $res[$i]['time'] = floor($res[$i]['time']/3600)."小时前";
                }elseif($res[$i]['time'] < 60){
                    $res[$i]['time'] = "刚刚";
                }else{
                    $res[$i]['time'] = floor($res[$i]['time']/60)."分钟前";
                }
            }
        }
        return Response::show('200','yes',$res);;
    }

    public function actionCreate()
    {
        header("Access-Control-Allow-Origin:".Yii::$app->params['hostname']);
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(),'');
        $aid = Yii::$app->request->getBodyParam('aid');
        $uid = Yii::$app->request->getBodyParam('created_id');
        $content = Yii::$app->request->getBodyParam('content');
        $article = (new Query())->select('status')->from('{{%article_comment}}')->where(['aid'=>$aid,"created_id"=>$uid,"content"=>$content])->orderBy('created_at desc')->one();
        if($article){
            Response::show('202','评论失败','不能评论重复内容');
        }
        $model->status = 1;
        if($model->save()){
            Response::show('200','评论成功','评论成功');
        }else{
            Response::show('201','评论失败','评论失败');
        }
    }
}