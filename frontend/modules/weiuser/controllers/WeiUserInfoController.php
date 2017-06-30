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

/*    public function init()
    {
        $this->accessToken = new WeiChat();
        if(empty($this->accessToken->getCookie('openid'))){
            return $this->redirect('/weiuser/one-day-pa/index');
        }
        parent::init();
    }*/

    public function actionIndex()
    {
        $openid = "oLdyrv6Xai3EC-nJgH-MZ5Fn3UpY";
        $model = WeiUserInfo::findOne($openid);
        return $this->render('index',['model'=>$model]);
    }

    public function actionUser(){

        $openid = "oLdyrv6Xai3EC-nJgH-MZ5Fn3UpY";
        $model = WeiUserInfo::findOne($openid);
        return $this->render('user',['model'=>$model]);

    }
}
