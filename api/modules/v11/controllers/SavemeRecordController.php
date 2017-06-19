<?php
namespace api\modules\v11\controllers;

use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;

class SavemeRecordController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\SavemeRecord';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    public function actionCreate(){
        $created_name = Yii::$app->request->getBodyParam('created_name');
        $to_name = Yii::$app->request->getBodyParam('to_name');
        $created_user = (new Query())->select('id,sex')->from('{{%user}}')->where(['username'=>$created_name])->one();
        $to_user = (new Query())->select('id,sex')->from('{{%user}}')->where(['username'=>$to_name])->one();
        if(!$created_user){
            Response::show(202,'发起人不存在');
        }
        if(!$to_user){
            Response::show(202,'对话人不存在');
        }
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');
        $decode = new yii\myhelper\Decode();
        if(!$decode->decodeDigit($created_name)){
            Response::show(210,'参数不正确');
        }
        if($created_user['sex'] == 1){
            $girl_id = $created_user['id'];
            $boy_id = $to_user['id'];
        }else{
            $girl_id = $to_user['id'];
            $boy_id = $created_user['id'];
        }
        $saveme = (new Query())->select('id')->from('{{%saveme}}')->where(['created_id'=>$girl_id])->orderBy('created_at desc')->one();
        $saveme_id = $saveme['id'];
//        $saveme_info = (new Query())->select('id')->from('{{%saveme_apply}}')->where(['saveme_id'=>$saveme_id,'apply_uid'=>$boy_id])->one();
//        if(!$saveme_info){
//            Response::show(203,'男生没有报名');
//        }
        $recordres = (new Query())->select('id,created_id,created_at')->from('{{%saveme_record}}')->where(['boy_id'=>$boy_id,'girl_id'=>$girl_id,'saveme_id'=>$saveme_id])->one();
        $time = time();
        if($recordres && (($time-$recordres['created_at'])<=(7*3600*24)) && $recordres['created_id'] != $created_user['id']){
            $res = Yii::$app->db->createCommand("update pre_saveme_apply set status = 1 where apply_uid = {$boy_id} AND saveme_id = {$saveme_id}")->execute();
        }

        $model->saveme_id = $saveme_id;
        $model->girl_id = $girl_id;
        $model->boy_id = $boy_id;
        $model->created_id = $created_user['id'];
        $model->status = 1;
        if (!$model->save()) {
            Response::show('201',array_values($model->getFirstErrors())[0], $model->getFirstErrors());
        }
        Response::show(200,'添加成功','添加成功');
    }
}