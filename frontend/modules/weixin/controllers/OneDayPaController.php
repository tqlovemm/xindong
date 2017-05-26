<?php

namespace frontend\modules\weixin\controllers;
use yii\web\Controller;
use Yii;
use yii\myhelper\AccessToken;
class OneDayPaController extends Controller
{
    public function actionIndex()
    {
        $callback = "http://13loveme.com/weixin/one-day-pa/wei-user";
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . Yii::$app->params['id_ks'] . "&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        return $this->redirect($url);
    }

    public function actionWeiUser(){
        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');
        if(!empty($data['code'])){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . Yii::$app->params['id_ks'] . "&secret=" . Yii::$app->params['secret_ks'] . "&code={$data['code']}&grant_type=authorization_code";
            $access = file_get_contents($url);
            $result = json_decode($access);
            AccessToken::addCookie('onedaypa_openid_ks',$result->openid);
            return $this->redirect('share-article');
        }else{
            return $this->redirect('index');
        }
    }

    public function actionShareArticle(){

        $access = new AccessToken();
        $openid = $access::getCookie('onedaypa_openid_ks');
        $userInfo = $access::getUserInfo($openid);
        return $this->render('share-article',['userInfo'=>$userInfo,'openid'=>$openid]);
    }
}
