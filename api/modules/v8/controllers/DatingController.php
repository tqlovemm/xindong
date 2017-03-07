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

        $where = ' status = 2 and cover_id = 0 ';
        if(!empty($time) && $time === 1){

            $t = time()-86400;
            $where['cover_id'] = 0;
            $where .= ' and created_at > '.$t;
        }
        if(!empty($title)){

            $where .= " and title = '".$title."'";
        }

        $query = $model::find()->where($where)->orderBy(' updated_at desc');
        //return $model::find()->where($where)->orderBy(' created_at desc')->createCommand()->getRawSql();
        return new ActiveDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }

}