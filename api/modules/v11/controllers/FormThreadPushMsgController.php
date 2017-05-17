<?php
namespace api\modules\v11\controllers;

use api\modules\v11\models\FormThreadPushMsg;
use yii;
use yii\helpers\Response;
use yii\rest\ActiveController;
use api\components\CsvDataProvider;
use yii\web\NotFoundHttpException;

class FormThreadPushMsgController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadPushMsg';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();

        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    /**
     * @return CsvDataProvider
     * v11/form-thread-push-msgs?thread_id={thread_id}
     * type=1获取已读消息，type=0获取未读消息，无参数type则为所有消息
     * 获取所有和他有关的帖子id，
     */

    public function actionIndex() {

    	$model = $this->modelClass;
        $user_id = Yii::$app->request->get('user_id');
        $type = Yii::$app->request->get('type');
        if(!empty($type)){
            $query = $model::find()->where(['user_id'=>$user_id,'read_user'=>$type]);
        }else{
            $query = $model::find()->where(['user_id'=>$user_id]);
        }
        FormThreadPushMsg::updateAll(['read_user'=>1],['user_id'=>$user_id]);
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

    /**
     * 消息id
     * @param $id
     * delete
     * v11/form-thread-push-msgs/{id}?user_id={user_id}&type={11或12}  11删除单个消息，12删除所有和我有关的消息
     * 获取所有和他有关的未读消息数量integer类型，
     * 含有sign加密
     */

    public function actionDelete($id){

        $user_id = Yii::$app->request->get('user_id');
        $type = Yii::$app->request->get('type');
        $decode = new yii\myhelper\Decode();
        if(!$decode->decodeDigit($user_id)){
            Response::show(210,'参数不正确');
        }
        if($type==11){
            if($this->findModel($id)->delete()){
                Response::show(200,'删除该消息成功');
            }
        }elseif($type==12){
            $model = $this->modelClass;
            if($model::deleteAll(['user_id'=>$user_id])){
                Response::show(200,'删除所有消息成功');
            }
        }else{
            Response::show(201,'参数错误');
        }
    }

    public function actionView($id) {

    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

}

