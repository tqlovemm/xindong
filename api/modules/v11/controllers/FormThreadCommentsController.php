<?php
namespace api\modules\v11\controllers;

use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;

class FormThreadCommentsController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadComments';
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

    public function actionCreate() {

    	$model = new $this->modelClass();
    	$model->load(Yii::$app->request->getBodyParams(), '');
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        return $model;
    }

    public function actionDelete($id)
    {
       return $this->findModel($id)->delete();
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

