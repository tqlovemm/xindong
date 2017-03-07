<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 16:25
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class ComplainController extends Controller
{

    public $modelClass = 'api\modules\v4\models\Complaint';

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
    public function actionCreate()
    {

        $model = new $this->modelClass();
        $decode = new Decode();
        if(!$decode->decodeDigit($model->plaintiff_id)){
            Response::show(210,'参数不正确');
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (!$model->save()) {

            return array_values($model->getFirstErrors())[0];
        }

        Response::show('202','保存成功');

    }
}