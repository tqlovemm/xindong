<?php

namespace api\modules\v7\controllers;

use api\modules\v11\models\FormThreadPushMsg;
use api\modules\v11\models\User;
use api\modules\v3\models\AppPush;
use yii\data\ActiveDataProvider;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;


class AppPushController extends ActiveController
{

    public $modelClass = 'api\modules\v3\models\AppPush';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    =>  'items',
    ];

    public function behaviors()
    {
        return parent::behaviors(); // TODO: Change the autogenerated stub
    }

    public function actions()
    {
        $actions = parent::actions(); // TODO: Change the autogenerated stub
        unset($actions['index'],$actions['view'],$actions['create'],$actions['update'],$actions['delete']);
        return $actions;
    }

    public function actionIndex(){

        $model = $this->modelClass;
        $cid = $_GET['cid'];
        $query = $model::find()
            ->where(" cid = '{$cid}' and `type` <> 'SSCOMM_NEWSCOMMENT_DETAIL' and is_read = 1 ")
            ->orderBy('created_at desc');
        return new ActiveDataProvider([
            'query' =>  $query
        ]);
    }

    public function actionView($id){
        if(strlen($id)>10){
            $userModel = User::findOne(['cid'=>$id]);
            $cid = $id;
            $uid = $userModel->id;
        }else{
            $userModel = User::findOne($id);
            $cid = $userModel->cid;
            $uid = $id;
        }
        $pushModel = ArrayHelper::map(AppPush::find()->select('count(*) as count,type')->where(['cid'=>$cid,'is_read'=>1])->groupBy('type')->asArray()->all(),'type','count');

        $query['unread_thread_count'] = (int)FormThreadPushMsg::find()->where(['user_id'=>$uid,'read_user'=>0])->count();
        $query['other_saveme_count'] = isset($pushModel['SSCOMM_SAVEME'])?$pushModel['SSCOMM_SAVEME']:0;
        $query['other_message_count'] = array_sum($pushModel)-$query['other_saveme_count'];
        $query['unread_count'] = array_sum($query);

        return $query;

    }
}