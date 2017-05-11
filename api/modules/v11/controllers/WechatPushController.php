<?php
namespace api\modules\v11\controllers;

use yii;
use yii\helpers\Response;
use yii\rest\ActiveController;
use api\components\CsvDataProvider;
use yii\web\NotFoundHttpException;


class WechatPushController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\WechatPush';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    /**
     * sign加密验证  （210,'参数不正确'）('200','ok')，('201','错误信息')
     * v11/wechat-pushes
     * post
     * 必传参数，user_id,recharge_id(充值后id)
     * 可选参数，wechat
     */

    public function actionCreate() {

    	$model = new $this->modelClass();
    	$model->load(Yii::$app->request->getBodyParams(), '');
        $decode = new yii\myhelper\Decode();
        if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }
        if (!$model->save()) {
            Response::show('201',array_values($model->getFirstErrors())[0], $model->getFirstErrors());
        }else{
            Response::show('200','ok');
        }


    }

/*    public function actionView($id) {

        $model = $this->findModel($id);
        return $model;
    }

    public function actionDelete($id)
    {
       if($this->findModel($id)->delete()){
           Response::show('200','ok');
        }
    }*/

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

