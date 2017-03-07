<?php
namespace api\modules\v8\controllers;

use api\modules\v8\models\ProfileData;
use api\modules\v8\models\User3;
use Yii;
use yii\rest\Controller;

class User3Controller  extends  Controller{

    public $modelClass = 'api\modules\v8\models\User3';
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

    public function actionIndex(){

        $data = Yii::$app->request->get('data');
        $data = json_decode($data);
        $data2 = array();
        foreach($data as $item){
            $data2[] = "\"".$item."\"";
        }

        $username = implode(',',$data2);
        $modelclass = new $this->modelClass();
        $model = $modelclass::find()->joinWith('address')->where(" username in ({$username}) ")->all();

        $info = array();
        foreach($model as $list){

            $address = $list['address'];
            foreach($address as $li){
                $addr = $li['address'];
                if(!empty($addr)){
                    $list['addr'] = $addr;
                }

            }
            $info[] = $list;
            unset($info['address']);
        }

        return $info;
    }
}