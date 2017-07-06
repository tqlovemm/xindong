<?php
namespace common\components;
use Yii;

class WeiChat
{
    public function getAccessToken() {
        $cache = Yii::$app->cache;
        $data = $cache->get('zs_access_token');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . Yii::$app->params['zs_app_id'] . "&secret=" . Yii::$app->params['zs_app_secret'];
            $res = json_decode(self::getData($token_access_url));
            $access_token = $res->access_token;
            if ($access_token) {
                $cache->set('zs_access_token',$access_token,7000);
            }
        } else {
            $access_token = $data;
        }
        return $access_token;
    }

    /**
     * @param $url
     * @return mixed
     * get请求
     */
    public function getData($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    /**
     * @param $url
     * @param $data
     * @return mixed|string
     * post请求
     */
    public function postData($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }



    /**
     * @param $openid
     * @return mixed
     * 获取用户信息
     */
    public function getUserInfo($openid){

        $token = self::getAccessToken();
        $url3 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid";
        $userInfo = json_decode(file_get_contents($url3),true);
        if(isset($userInfo['errcode'])&&$userInfo['errcode']==40001){
            Yii::$app->cache->delete('zs_access_token');
            self::getUserInfo($openid);
        }
        return $userInfo;
    }

    /**
     * @param $cookie_name
     * @param $cookie_value
     * @param int $expire
     */
    public function addCookie($cookie_name,$cookie_value,$expire=24){

        $cookies = \Yii::$app->response->cookies;
        $cookie = \Yii::$app->request->cookies;
        if(empty($cookie->get($cookie_name))){
            $cookies->add(new \yii\web\Cookie([
                'name' => $cookie_name,
                'value' => $cookie_value,
                'expire'=>time()+3600*($expire+8),
            ]));
        }
    }

    public function getCookie($cookie_name){
        $cookie = \Yii::$app->request->cookies;
        return $cookie->getValue($cookie_name);
    }

    public function delCookie($cookie_name){
        $cookie = \Yii::$app->response->cookies;
        return $cookie->remove($cookie_name);
    }

}