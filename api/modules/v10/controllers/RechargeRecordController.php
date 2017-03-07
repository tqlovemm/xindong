<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 14:59
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class RechargeRecordController extends Controller
{

    public $modelClass = 'api\modules\v4\models\RechargeRecord';
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

    public function actionView($id)
    {

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $type = Yii::$app->request->get('type');
        $modelClass = $this->modelClass;
        if($type==1001){

            $model = $modelClass::find()->where(['user_id'=>$id])->orderBy('updated_at desc');

        }elseif($type==2112){

            $model = $modelClass::find()->where(['user_id'=>$id,'subject'=>3])->orderBy('updated_at desc');

        }else{

            $model="非法操作";

        }

        return new ActiveDataProvider([

            'query' => $model,
        ]);


    }
}