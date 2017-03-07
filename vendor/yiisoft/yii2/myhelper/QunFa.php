<?php

namespace yii\myhelper;

class QunFa{

    private $access_token;
    //
    public function __construct($access_token) {

        $this->access_token = $access_token;
    }
    //
    function getData($url){
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
    //
    function postData($url,$data){
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
    //

    public function getUserInfo(){

        $res = $this->addUserInfo();
        $count = floor($res['total']/10000);

        $result = $res['data']['openid'];

        for($i=0;$i<$count;$i++){

            $next_openid = $res['next_openid'];

            $result = array_merge($result,$this->addUserInfo($next_openid)['data']['openid']);
        }


        return $result;
    }

    protected function addUserInfo($next_openid=''){

        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->access_token."&next_openid=$next_openid";
        $res = json_decode($this->getData($url),true);
        return $res;
    }


    public function sendMsgToAll(){
        $userInfoList = $this->getUserInfo();
        $url = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=".$this->access_token;
        foreach($userInfoList as $val){
            $data = '{
              "touser":"'.$val.'",
              "msgtype":"text",
              "text":
              {
                "content":"测试一下，抱歉打扰各位
                    您的微信号是
                    您的账单是
                    您的 falkefaewfa
                    案范围发发
                    fawefafwe
                    afewfawfawfewafawfawef
                    法尔无法无法
                    fawef fawefawef发违法
                    发违法个人头
                    发文发文发
                "
              }
            }';
            $this->postData($url,$data);
        }
    }
}