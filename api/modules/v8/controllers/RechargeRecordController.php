<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/9
 * Time: 13:43
 */

namespace api\modules\v8\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class RechargeRecordController extends ActiveController
{

    public $modelClass = 'api\modules\v8\models\RechargeRecord';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope' =>  'item',
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

        $detail = $model::find()->where(['user_id'=>$id,'status'=>[10,11,12],'platform'=>1])->orderBy(' created_at desc ');

        return new ActiveDataProvider([
            'query' =>  $detail,
        ]);
    }
}