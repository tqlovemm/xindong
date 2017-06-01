<?php
namespace api\modules\v11\controllers;


use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use api\components\CsvDataProvider;
use yii\db\Query;
use yii\helpers\Response;

class ArticleController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\Article';
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

    public function actionIndex() {
        $model = $this->modelClass;
        $tid = isset($_GET['tid'])?$_GET['tid']:'';
        $hot = isset($_GET['hot'])?$_GET['hot']:'';
        $userid = isset($_GET['uid'])?$_GET['uid']:'';
        if(!$userid){
            Response::show('201','获取失败','参数不全');
        }
        $where = ' status = 1';
        if(!empty($tid)){
            $where .= " and wtype = '".$tid."'";
        }
        if(!empty($hot)){
            $where .= " and hot = '".$hot."'";
        }
        $query = $model::find()->where($where)->orderBy('updated_at desc');
        $res = new CsvDataProvider(
            [
                'query' =>  $query,
            ]
        );
        return $res;
    }
}