<?php
namespace api\modules\v11\controllers;


use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use api\components\CsvDataProvider;

class ArticleAdverController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\ArticleAdver';
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

    public function  actionIndex(){
        $model = new $this->modelClass();
        $where = ' status = 1';
        $query = $model::find()->where($where)->orderBy('created_at desc');
        return new CsvDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }
}