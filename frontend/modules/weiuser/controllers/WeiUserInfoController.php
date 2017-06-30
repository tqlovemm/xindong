<?php

namespace frontend\modules\weiuser\controllers;

use common\components\Vip;
use frontend\modules\weiuser\models\AddressList;
use frontend\modules\weiuser\models\WeiUserAddress;
use frontend\modules\weiuser\models\WeiUserInfo;
use Yii;
use common\components\WeiChat;
use yii\helpers\ArrayHelper;
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
        $userModel = WeiUserInfo::findOne($this->openid);
        $model = ArrayHelper::map(AddressList::find()->where(['level'=>0])->asArray()->all(),'code','region_name_c');
        return $this->render('country',['model'=>$model,'userModel'=>$userModel]);
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

    public function actionA($ip='47.90.23.171'){

        $current_Ip_Info = $this->getIpInfo($ip);
        var_dump($current_Ip_Info);
    }
    function getIpInfo($ip,$timeout=15) {

        if(!function_exists('curl_init') or !function_exists('simplexml_load_string')) return false;
        $ch = curl_init("http://ipinfodb.com/ip_query2.php?ip={$ip}&timezone=true");
        $options = array(
            CURLOPT_RETURNTRANSFER => true,
        );
        curl_setopt_array($ch,$options);
        $res = curl_exec($ch);
        curl_close($ch);

        if($xml = simplexml_load_string($res)) {
            $return = array();
            foreach ($xml->Location->children() as $key=>$item)  {
                $return[$key] = strtolower($item);
            }
            return $return;
        } else {
            return false;
        }
    }


}
