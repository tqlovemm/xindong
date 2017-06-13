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
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');
//        $created_id = Yii::$app->request->getBodyParam('created_id');
//        $decode = new yii\myhelper\Decode();
//        if(!$decode->decodeDigit($created_id)){
//            Response::show(210,'参数不正确');
//        }
        $saveme_id = $model->saveme_id;
        $boy_id = $model->boy_id;
        $girl_id = $model->girl_id;
        $recordres = (new Query())->select('created_at')->from('{{%saveme_record}}')->where(['boy_id'=>$boy_id,'girl_id'=>$girl_id,'saveme_id'=>$saveme_id])->one();
        $time = time();
        if($recordres && (($time-$recordres['created_at'])<=(7*3600*24))){
            $res = Yii::$app->db->createCommand("update pre_saveme_apply set status = 1 where apply_uid = {$boy_id} AND saveme_id = {$saveme_id}")->execute();
            if(!$res){
                Response::show(201,'update error','数据修改失败');
            }
        }
        $model->status = 1;
        if (!$model->save()) {
            Response::show('201',array_values($model->getFirstErrors())[0], $model->getFirstErrors());
        }
        Response::show(200,'添加成功','添加成功');
    }
}