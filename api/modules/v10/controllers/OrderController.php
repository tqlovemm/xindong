<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/23
 * Time: 10:38
 */

namespace api\modules\v10\controllers;


use yii\data\ActiveDataProvider;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class OrderController extends Controller
{

    public $modelClass = 'api\modules\v8\models\Order';
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

    public function actionView($id){


        $model = $this->modelClass;
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $detail = $model::find()->where(['user_id'=>$id,'status'=>1])->orderBy(' created_at desc ');

        return new ActiveDataProvider([
            'query' =>  $detail,
        ]);
    }
}