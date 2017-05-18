<?php

namespace api\modules\v9\controllers;


use api\components\CsvDataProvider;
use yii;
use yii\rest\ActiveController;


class AppSpecialDatingController extends ActiveController
{

    public $modelClass = 'api\modules\v9\models\AppSpecialDating';
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
     * 获取单个专属女生信息接口
     * get
     * v9/app-special-dating-sign-ups/{zid}专属女生编号
     * 存在状态
     * 0.'401','该女生不存在'
     */
    public function actionView($id){

        $model = $this->findModel($id);
        if(empty($model)){
            yii\myhelper\Response::show(401,'该女生不存在','该女生不存在');
        }
        return $model;
    }

    /**
     * 获取所有专属女生信息接口
     * get
     * v9/app-special-dating-sign-ups
     * 拼接字段?area={area} 该地区的所有专属女生，不拼接则为全地区 于time字段互为叠加
     * 拼接字段?time=1 24小时之内的所有女生，与area字段互为叠加
     *
     * 200获取成功
     */
    public function actionIndex(){

        $getArea = Yii::$app->request->get('area');
        $getTime = Yii::$app->request->get('time');
        $model = $this->modelClass;
        $query = $model::find()->where(['status'=>10]);
        if(!empty($getTime)&&$getTime==1){
            $query = $query->andWhere("`created_at`>unix_timestamp(now())-86400");
        }
        if(!empty($getArea)){
            $query = $query->andWhere(['address'=>$getArea]);
        }

        return new CsvDataProvider([
            'query' =>  $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
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