<?php

namespace frontend\modules\weiuser\controllers;

use frontend\modules\weiuser\models\WeiUserInfo;
use Yii;
use common\components\WeiChat;
use yii\web\Controller;

class WeiUserInfoController extends Controller
{
    public $enableCsrfValidation = false;

    public $layout = '/basic';

    public $accessToken;

    public function init()
    {
        $this->accessToken = new WeiChat();
        if(empty($this->accessToken->getCookie('openid'))){
            return $this->redirect('/weiuser/one-day-pa/index');
        }
        parent::init();
    }

    public function actionIndex()
    {
        return var_dump($this->accessToken->getCookie('openid'));
    }

}
