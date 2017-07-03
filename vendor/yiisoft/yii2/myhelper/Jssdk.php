<?php
namespace yii\myhelper;
use common\components\WeiChat;
use Yii;

class Jssdk
{
    public $appId;
    public $appSecret;
    public $cache;

    public function __construct()
    {
        $this->appId = Yii::$app->params['zs_app_id'];
        $this->appSecret = Yii::$app->params['zs_app_secret'];
        $this->cache = Yii::$app->cache;
    }

    public function getSignPackage() {
        $jsapiTicket = $this->getJsApiTicket();

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1($string);

        $signPackage = array(
            "appId"     => $this->appId,
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }


    private function getJsApiTicket() {

        $data = $this->cache->get('jsapi_ticket');
        if (empty($data)) {
            $accessToken = (new WeiChat())->getAccessToken();
            $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=$accessToken";
            $res = json_decode((new WeiChat())->getData($url));
            $ticket = $res->ticket;
            if ($ticket) {
                $this->cache->set('jsapi_ticket',$ticket,7000);
            }
        } else {
            $ticket = $data;
        }
        return $ticket;
    }


}