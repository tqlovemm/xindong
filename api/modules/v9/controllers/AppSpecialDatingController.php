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

    public function actionView($id){

        $model = $this->findModel($id);
        if(empty($model)){
            yii\myhelper\Response::show(401,'该女生不存在','该女生不存在');
        }
        return $model;
    }

    public function actionIndex(){

        $getData = Yii::$app->request->get('area');
        $model = $this->modelClass;
        if(!empty($getData)){
            $query = $model::find()->where(['status'=>10,'address'=>$getData]);
        }else{
            $query = $model::find()->where(['status'=>10]);
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