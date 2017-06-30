<?php

namespace frontend\modules\weiuser\controllers;

use frontend\modules\weiuser\models\WeiUserInfo;
use Yii;
use common\components\WeiChat;
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
        $this->openid = !empty($this->accessToken->getCookie('openid'))?$this->accessToken->getCookie('openid'):"oLdyrv6Xai3EC-nJgH-MZ5Fn3UpY";
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
        return var_dump($this->accessToken->getCookie('openid'));
        $model = WeiUserInfo::findOne($this->openid);
        return $this->render('user',['model'=>$model]);

    }
}
