<?php

namespace frontend\modules\weiuser\controllers;

use common\components\Vip;
use frontend\modules\weiuser\models\AddressList;
use frontend\modules\weiuser\models\WeiUserAddress;
use frontend\modules\weiuser\models\WeiUserInfo;
use Yii;
use common\components\WeiChat;
use yii\helpers\ArrayHelper;
use yii\myhelper\Jssdk;
use yii\web\Controller;

class WeiUserInfoController extends Controller
{
    public $enableCsrfValidation = false;
    public $layout = 'weiuser';
    public $accessToken;
    public $openid;

   public function init()
    {
        $this->accessToken = new WeiChat();
        $this->openid = !empty($this->accessToken->getCookie('zs_openid'))?$this->accessToken->getCookie('zs_openid'):"oLdyrv6Xai3EC-nJgH-MZ5Fn3UpY";
        if(empty($this->openid)){
            return $this->redirect('/weiuser/one-day-pa/index');
        }
        parent::init();
    }

    public function actionProfile()
    {
        $model = WeiUserInfo::findOne($this->openid);
        return $this->render('profile',['model'=>$model]);
    }

    public function actionUser(){
        $model = WeiUserInfo::findOne($this->openid);
        return $this->render('user',['model'=>$model]);
    }

    public function actionCountry(){
        $jsdk = new Jssdk(Yii::$app->params['zs_app_id'],Yii::$app->params['zs_app_secret']);
        $signPackage = $jsdk->getSignPackage();
        $userModel = WeiUserInfo::findOne($this->openid);
        $model = ArrayHelper::map(AddressList::find()->where(['level'=>0])->asArray()->all(),'code','region_name_c');
        return $this->render('country',['model'=>$model,'userModel'=>$userModel,'signPackage'=>$signPackage]);
    }

    public function actionProvince($code){

        $areaList = ArrayHelper::map(AddressList::find()->where(['upper_region'=>$code])->asArray()->all(),'code','region_name_c');
        if(empty($areaList)){
            $userModel = WeiUserInfo::findOne($this->openid);
            $areaModel = new WeiUserAddress();
            $area = Vip::wholeArea($code);

            if(($model = $areaModel::findOne($userModel->thirteen_platform_number))==null){
                $areaModel->thirteen_platform_number = $userModel->thirteen_platform_number;
                $areaModel->country = $area['country'];
                $areaModel->province = $area['province'];
                $areaModel->city = $area['city'];
                $areaModel->save();
            }else{
                $model->country = $area['country'];
                $model->province = $area['province'];
                $model->city = $area['city'];
                $model->update();
            }

            return $this->redirect('profile');

        }
        return $this->render('province',['model'=>$areaList]);
    }

}
