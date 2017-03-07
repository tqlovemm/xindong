<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/7
 * Time: 14:28
 */

namespace yii\myhelper;

use Yii;
class AccessToken
{
    public $cache = '';

    public function getAccessToken() {
        $this->cache = Yii::$app->cache;
        $data = $this->cache->get('access_token_js');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . Yii::$app->params['appid'] . "&secret=" . Yii::$app->params['appsecret'];
            $res = json_decode($this->getData($token_access_url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->set('access_token_js',$access_token,7000);
            }
        } else {
            $access_token = $data;
        }
        return $access_token;
    }

    public function getAccessTokenSub(){

        $this->cache = Yii::$app->cache;
        $data = $this->cache->get('access_token_sub');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx7468c28e27022d39&secret=27b190a29b7ec62f82d9ad411849252e";
            $res = json_decode($this->getData($token_access_url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->set('access_token_sub',$access_token,7000);
            }
        } else {
            $access_token = $data;
        }
        return $access_token;
    }

    public static function antiBlocking(){
        $cache = Yii::$app->cache;
        $data = $cache->get('anti_blocking');
        $random = Random::get_random_code(8);
        if (empty($data)) {
            $data = $cache->set('anti_blocking',$random,86400);
        }
        return $data;
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


}