<?php
namespace api\modules\v11\controllers;

use yii;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\web\NotFoundHttpException;

class FormThreadReportController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadReport';
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
     * 投诉post
     * /v11/form-thread-reports?access-token={cid}
     * 必填参数：user_id投诉人id；report_id投诉选项id；wid帖子id
    */
    public function actionCreate() {

        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');
        $decode = new yii\myhelper\Decode();
        if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }else{
            Response::show('200','ok');
        }
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

