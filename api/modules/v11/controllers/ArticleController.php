<?php
namespace api\modules\v11\controllers;

use common\Qiniu\QiniuUploader;
use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\Pagination;
use yii\myhelper\Decode;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
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
        $where = ' status = 1';
        $query = $model::find()->where($where)->orderBy('updated_at desc');
        return new CsvDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }
}