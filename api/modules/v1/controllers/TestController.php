<?php

namespace api\modules\v1\controllers;

use yii\rest\ActiveController;

/**
 * Country Controller API
 *
 * @author Budi Irawan <deerawan@gmail.com>
 */
class TestController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // token 验证  请按需开启
        /*   $behaviors['authenticator'] = [
               'class' => CompositeAuth::className(),
               'authMethods' => [
                   QueryParamAuth::className(),
               ],
           ];*/
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionIndex(){
        return \Yii::$app->controller->getRoute();
    }
    public function actionView($id){

        return \Yii::$app->controller->getRoute();
    }

    public function actionCreate(){
        return \Yii::$app->controller->getRoute();
    }

    public function actionUpdate($id){
        return \Yii::$app->controller->getRoute();
    }

    public function actionDelete($id){
        return \Yii::$app->controller->getRoute();
    }

}


