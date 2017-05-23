<?php

namespace api\modules\v8\controllers;
use Yii;
use yii\data\ActiveDataProvider;
use yii\rest\ActiveController;

class DatingController extends ActiveController
{

    public $modelClass = 'api\modules\v8\models\Dating';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    => 'items',
    ];

    public function behaviors(){

        return parent::behaviors();
    }

    public function actions(){

        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['update'],$actions['create'],$actions['delete']);
        return $actions;
    }

    public function actionIndex(){

        $model = $this->modelClass;
        $time = isset($_GET['time'])?htmlspecialchars($_GET['time']):'';
        $title = isset($_GET['title'])?$_GET['title']:'';

        $query = $model::find()->where(['status' => 2,'cover_id' => 0]);
        $t = time()-86400*3;
        if(!empty($time) && $time == 1){
            $query = $query->andWhere("updated_at>$t");
        }
        if(!empty($title)){
            $query = $query->andWhere(['title'=>$title]);
        }
        return new ActiveDataProvider(
            [
                'query' =>  $query,
                'pagination' => [
                    'pageSize' => 20,
                ],
                'sort' => [
                    'defaultOrder' => [
                        'updated_at' => SORT_DESC,
                    ]
                ],
            ]
        );
    }
}