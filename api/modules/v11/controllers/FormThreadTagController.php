<?php
namespace api\modules\v11\controllers;

use yii;

use yii\rest\ActiveController;
use api\components\CsvDataProvider;
use yii\filters\RateLimiter;
use yii\web\NotFoundHttpException;

class FormThreadTagController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadTag';
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

    /**
     * @return CsvDataProvider
     * 查看所有帖子接口get
     * /v11/form-thread-tags?access-token={cid}
     * 若access-token不存在或错误则返回如下
     * {
        "name": "Unauthorized",
        "message": "You are requesting with an invalid credential.",
        "code": 0,
        "status": 401,
        "type": "yii\\web\\UnauthorizedHttpException"
        }
     */
    public function actionIndex() {

    	$model = $this->modelClass;
        $query =  $model::find()->where(['status'=>10]);

        return new CsvDataProvider([
            'query' =>  $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'sort' => SORT_ASC,
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
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

