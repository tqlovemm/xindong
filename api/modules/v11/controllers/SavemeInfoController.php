<?php
namespace api\modules\v11\controllers;

use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\myhelper\Decode;
use api\modules\v11\models\Saveme;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimiter;
class SavemeInfoController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\SavemeInfo';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    => 'items',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }
    public function actions() {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }
    public function actionView($id) {
        $model = new $this->modelClass();
        $query = $model::find()->where(['apply_uid'=>$id])->orderBy('created_at desc');
        return new ActiveDataProvider(
            [
                'query' =>  $query,
            ]
        );
    }
    public function actionCreate() {
        $model = new $this->modelClass();
        $model2 = new Saveme;
        $model->load(Yii::$app->request->getBodyParams(), '');
        $sid = $model->saveme_id;
        $aid = $model->apply_uid;
        $address = (new Query())->select('address')->from('{{%user_profile}}')->where(['user_id'=>$aid])->one();
        $saveme = $model2::find()->where(['id'=>$sid])->one();
        $address = explode(" ",$address['address']);
        if ($address[0] != $saveme['address']) {
            Response::show('202','操作失败',"用户城市与目标城市不符合");
        }
        $applyres = (new Query())->select('saveme_id,apply_uid,status')->from('{{%saveme_apply}}')->where(['saveme_id'=>$sid,'apply_uid'=>$aid])->orderBy('created_at desc')->one();
        if ($applyres) {
            Response::show('201','操作失败',"您已经申请过该救火");
        }
        $model->created_at = time();
        $model->updated_at = time();
        $model->status = 0;
        if(!$model->save()){
            // return $model->getFirstErrors();
            Response::show('201','操作失败',"申请失败");
        }
        Response::show('200','操作成功',"申请成功");
    }
    public function actionUpdate($id) {
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new $this->modelClass();
        $myapply = $model::find()->select('saveme_id,apply_uid,status')->where(['apply_uid'=>$id])->orderBy('created_at desc')->one();
        $saveme_id = $myapply['saveme_id'];
        $apply_uid = $myapply['apply_uid'];
        if ($myapply['status'] > 0) {
            Response::show('201','操作失败',"已经审核过了");
        }
        $res1 = Yii::$app->db->createCommand("update pre_saveme_apply set status = 2 where saveme_id = {$saveme_id}")->execute();
        if (!$res1) {
            Response::show('201','操作失败',"审核失败");
        }
        $res2 = Yii::$app->db->createCommand("update pre_saveme_apply set status = 1 where saveme_id = {$saveme_id} and apply_uid = {$apply_uid}")->execute();
        if (!$res2) {
            Response::show('201','操作成功',"审核失败");
        }
        $res3 = Yii::$app->db->createCommand("update pre_saveme set status = 2 where id = {$saveme_id}")->execute();
        if ($res3) {
            Response::show('200','操作成功',"审核成功");
        }
        Response::show('201','操作成功',"审核失败");
    }
}

