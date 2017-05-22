<?php
namespace api\modules\v11\controllers;


use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use api\components\CsvDataProvider;

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
        $where = ' status = 1';
        if(!empty($tid)){
            $where .= " and wtype = '".$tid."'";
        }
        if(!empty($hot)){
            $where .= " and hot = '".$hot."'";
        }
        $query = $model::find()->where($where)->orderBy('updated_at desc');
        return new CsvDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }
}