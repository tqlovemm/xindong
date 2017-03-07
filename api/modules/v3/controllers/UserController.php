<?php

namespace api\modules\v3\controllers;

use Yii;

use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

use yii\myhelper\Response;
class UserController extends ActiveController
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    public $modelClass = 'api\modules\v3\models\User';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }


    public function actionUpdate($id){

            $model = $this->findModel($id);

            $model->load(Yii::$app->getRequest()->getBodyParams(), '');

            if(!empty($model->password_reset_token)){

                    if (!$model->save()) {

                        return array_values($model->getFirstErrors())[0];

                    }

                    $data = array(
                        'id'=>$model->id,
                        'cid'=>$model->cid,
                        'password_reset_token'=>$model->password_reset_token,
                        'username'=>$model->username,
                        'nickname'=>$model->nickname,
                        'none'=>$model->none,
                        'cellphone'=>$model->cellphone,
                        'email'=>$model->email,
                        'sex'=>$model->sex,
                        'avatar'=>$model->avatar,

                    );

                    exit(Response::show(202,"update success",$data));
            }

        exit(Response::show(601,"update fail","非法操作"));

    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne(['cellphone'=>$id])) !== null) {
            return $model;
        } else {
            exit(Response::show(402,"update fail","user does not exist."));
        }

    }

}