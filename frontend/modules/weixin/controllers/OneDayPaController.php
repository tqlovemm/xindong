<?php

namespace frontend\modules\weixin\controllers;
use yii\web\Controller;
use Yii;
use yii\myhelper\AccessToken;
class OneDayPaController extends Controller
{
    public $accessToken;
    public function init()
    {
        $this->accessToken = new AccessToken();
        parent::init(); // TODO: Change the autogenerated stub
    }

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
            $result = json_decode($access,true);
            $openid = $result['openid'];
            $access_token = $result['access_token'];
            $user_info = $this->getUserInfo($openid,$access_token);
            $this->accessToken->addCookie('openid_ks_one_day_pa',$openid);
            $this->accessToken->addCookie('user_info_one_day_pa',$user_info);
            return $this->redirect('share-article');
        }else{
            return $this->redirect('index');
        }
    }

    protected function getUserInfo($openid,$access_token){

        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $res = $this->accessToken->getData($url);
        return $res;
    }
    public function actionShareArticle(){

        $openid= $this->accessToken->getCookie('openid_ks_one_day_pa');
        $userInfo= $this->accessToken->getCookie('user_info_one_day_pa');

        return $this->render('share-article',['userInfo'=>$userInfo,'openid'=>$openid]);
    }
}
