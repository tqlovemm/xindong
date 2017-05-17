<?php

namespace api\modules\v9\controllers;


use yii\myhelper\Response;
use yii;
use yii\rest\ActiveController;


class AppSpecialDatingSignUpController extends ActiveController
{

    public $modelClass = 'api\modules\v9\models\AppSpecialDatingSignUp';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];
    public function behaviors(){
        return parent::behaviors();
    }

    public function actions()
    {
        $actions =  parent::actions();
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }


    /**
     * 专属报名接口
     * post
     * v9/app-special-dating-sign-ups
     * 必传参数
     * user_id用户id,zid专属女生编号
     * sign 加密 {210,'参数不正确'}
     */

    public function actionCreate() {

        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');

        $decode = new yii\myhelper\Decode();
        /*if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }*/
        if (!$model->save()) {

            Response::show('201',array_values($model->getFirstErrors())[0], $model->getFirstErrors());
        }else{
            Response::show('200','报名成功','报名成功');
        }
    }

    public function findModel($id){

        $model = $this->modelClass;
        if($model = $model::findOne($id)){
            return $model;
        }else{
            return false;
        }
    }
}