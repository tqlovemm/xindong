<?php

namespace frontend\modules\weiuser\controllers;

use frontend\modules\weiuser\models\WeiUserInfo;
use Yii;
use common\components\WeiChat;
use yii\web\Controller;

class OneDayPaController extends Controller
{
    public $enableCsrfValidation = false;

    public $layout = '/basic';

    public $accessToken;

    public function init()
    {
        $this->accessToken = new WeiChat();
        parent::init(); // TODO: Change the autogenerated stub
    }

    public function actionIndex()
    {
        $callback = "http://13loveme.com/weiuser/one-day-pa/wei-user";
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=" . Yii::$app->params['zs_app_id'] . "&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        return $this->redirect($url);
    }

    public function actionWeiUser(){

        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');
        if(!empty($data['code'])){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=" . Yii::$app->params['zs_app_id'] . "&secret=" . Yii::$app->params['zs_app_secret'] . "&code={$data['code']}&grant_type=authorization_code";
            $access = file_get_contents($url);
            $result = json_decode($access,true);
            $openid = $result['openid'];
            $access_token = $result['access_token'];
            $user_info = $this->getUserInfo($openid,$access_token);
            $u = json_decode($user_info,true);
            var_dump($u);
            $model = new WeiUserInfo();
            if(($wei_user = $model::findOne($openid))==null){
                $model->openid = $u['openid'];
                $model->headimgurl = $u['headimgurl'];
                $model->nickname = $u['nickname'];
                if(!$model->save()){
                    return var_dump($model->errors);
                }
            }else{
                if(($wei_user->headimgurl!=$u['headimgurl']) || ($wei_user->nickname!=$u['nickname'])){
                    $wei_user->headimgurl = $u['headimgurl'];
                    $wei_user->nickname = $u['nickname'];
                    $wei_user->update();
                }
            }
            $this->accessToken->addCookie('zs_openid',$openid);
        }

        return $this->redirect('/weiuser/wei-user-info/user');

    }

    protected function getUserInfo($openid,$access_token){
        $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
        $res = $this->accessToken->getData($url);
        return $res;
    }

}
