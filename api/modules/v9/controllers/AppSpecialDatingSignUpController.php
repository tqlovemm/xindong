<?php

namespace api\modules\v9\controllers;

use api\modules\v9\models\AppSpecialDating;
use backend\models\User;
use common\components\Vip;
use frontend\models\UserData;
use yii\myhelper\Response;
use yii;
use yii\rest\ActiveController;


class AppSpecialDatingSignUpController extends ActiveController
{

    public $modelClass = 'api\modules\v9\models\AppSpecialDatingSignUp';
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
     * 专属报名接口
     * post
     * v9/app-special-dating-sign-ups
     * 必传参数
     * user_id用户id,zid专属女生编号
     *
     * sign 加密 {210,'参数不正确'}
     *
     * 存在状态
     * 0.'200','报名成功'
     * 1.'201','您的节操币不足请充值','您的节操币不足请充值'
     * 2.'201',"您的等级不足，专属女生仅限{$vip}报名","您的等级不足，专属女生仅限{$vip}报名"
     * 3.'201','报名人数已满，请等待开放'
     * 4.'203','用户ID不可为空'
     * 5.'203','专属女生编号不可为空'
     * 6.'202','该专属女生不存在'
     * 7.'202','报名男生不存在'
     */

    public function actionCreate() {

        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');

        $decode = new yii\myhelper\Decode();
            if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }
        $groupid = User::getVip($model->user_id);
        $coin = UserData::findOne($model->user_id);
        $specialModel = AppSpecialDating::findOne($model->zid);

        if(empty($groupid)){
            Response::show(202,'报名男生不存在','报名男生不存在');
        }
        if(empty($specialModel)){
            Response::show(202,'该专属女生不存在','该专属女生不存在');
        }

        if($coin->jiecao_coin<$specialModel->coin){
            Response::show(201,'您的节操币不足请充值','您的节操币不足请充值');
        }

        if($groupid<$specialModel->limit_vip){
            $vip = Vip::specialVip($specialModel->limit_vip);
            Response::show(201,"您的等级不足，专属女生仅限{$vip}报名","您的等级不足，专属女生仅限{$vip}报名");
        }

        if($specialModel->limit_count<=$specialModel->sign_up_count){
            Response::show(201,'报名人数已满，请等待开放','报名人数已满，请等待开放');
        }

        if(!$model->save()) {
            Response::show(201,array_values($model->getFirstErrors())[0], $model->getFirstErrors());
        }else{
            Response::show(200,'报名成功','报名成功');
        }
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