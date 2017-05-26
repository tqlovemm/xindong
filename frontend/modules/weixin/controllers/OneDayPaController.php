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
        $this->getCode($callback);
    }

    protected function getCode($callback){
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
            $token = (new AccessToken())->getAccessTokenKs();
            $openid = $result->openid;

            $url3 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid";
            var_dump($openid);
            $userInfo = json_decode(file_get_contents($url3),true);

            if(isset($userInfo['errcode'])&&$userInfo['errcode']==40001){
                Yii::$app->cache->delete('access_token_js');
                return $this->redirect('index');
            }

           // $this->addCookie('userweinfo',json_encode($userInfo));

           // $voteUrl = '/weixin/weichat-vote/vote-man';//投票地址

            return var_dump($userInfo);
            //return $this->redirect($voteUrl);
        }else{
            return $this->redirect('index');
        }

    }


}
