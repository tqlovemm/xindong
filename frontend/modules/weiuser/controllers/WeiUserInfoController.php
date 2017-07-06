<?php

namespace frontend\modules\weiuser\controllers;

use common\components\Vip;
use frontend\modules\weiuser\models\AddressList;
use frontend\modules\weiuser\models\WeiUserAddress;
use frontend\modules\weiuser\models\WeiUserInfo;
use Yii;
use common\components\WeiChat;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\myhelper\Jssdk;
use yii\rest\ViewAction;
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
        $jsdk = new Jssdk();
        $signPackage = $jsdk->getSignPackage();
        $userModel = WeiUserInfo::findOne($this->openid);
        $model = ArrayHelper::map(AddressList::find()->where(['level'=>0])->asArray()->all(),'code','region_name_c');
        return $this->render('country',['model'=>$model,'userModel'=>$userModel,'signPackage'=>$signPackage]);
    }

    public function actionSaveSex($sex){
        $userModel = WeiUserInfo::findOne($this->openid);
        $userModel->sex = $sex;
        if(!$userModel->update()){
            echo 404;
        }
        echo 200;

    }


    public function actionGetLocation($lat,$lon){
        $url = "http://api.map.baidu.com/geocoder?location=$lat,$lon&output=json";
        $result = (new WeiChat())->getData($url);
        $data = json_decode($result,true);
        $code = "#";
        if($data['status']=='OK'){
            $dataArray = $data['result']['addressComponent'];
            $province = $dataArray['province'];
            $city = $dataArray['city'];
            if(!empty($province)){
                $area = AddressList::find()->where(['like','region_name_c',$province])->asArray()->one();
                if(!empty($area)){
                    $code = "province?code=$area[code]";
                }
            }else{
                $province = "未知地区";
            }
            echo json_encode(['callback'=> $_GET['callback'],'province'=>$province,'city'=>$city,'code'=>$code]);
        }

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
