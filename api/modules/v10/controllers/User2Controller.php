<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 13:57
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class User2Controller extends Controller
{

    public $modelClass = 'api\modules\v2\models\User1';
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


    public function actionUpdate($id)
    {
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }

        $model = $this->findModel($id);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if(!empty(Yii::$app->request->post('avatar'))){
            $images = $model->avatar;
            $pathStr = "uploads/user/avatar";

            if ( !file_exists( $pathStr ) ) {
                if ( !mkdir( $pathStr , 0777 , true ) ) {
                    return false;
                }
            }
            $savePath = $pathStr.'/'.$id.'_'.time().rand(1,10000).'.jpg';
            file_put_contents($savePath,base64_decode($images));
            $abs_path = Yii::$app->params['hostname'].'/'.$savePath;//Yii::$app->request->getHostInfo().

            $model->avatar = $abs_path;
        }

        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        return $model;
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (is_numeric($id)) {
            $model = $modelClass::findOne($id);
        } else {
            $model = $modelClass::find()->where(['username' => $id])->asArray()->one();
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}