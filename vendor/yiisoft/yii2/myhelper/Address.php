<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/26
 * Time: 9:54
 */

namespace yii\myhelper;


class Address
{
    public function getAddress(){

        $add = $this->getIPLoc_sina($this->getIP());

        return $add;

    }
    function getIPLoc_sina($queryIP){

        if($queryIP=='::1'){
            return;
        }

        $url = 'http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=json&ip='.$queryIP;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_ENCODING ,'utf8');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true) ; // 获取数据返回
        $location = curl_exec($ch);
        $location = json_decode($location);
        curl_close($ch);

        $loc = "";
        if($location===FALSE) return "";

        if (empty($location->desc)) {

            if(!empty($location->country)){

                $loc = $location->country;

                if($loc=='中国'){

                    $loc = $location->province;

                    if($loc=='广东'){

                        $loc = $location->city;

                        if($loc=='广州'||$loc=='深圳'){

                            $loc = $location->city;

                        }else{

                            $loc = $location->province;
                        }
                    }
                }

            }else{

                $loc = '北京';
            }
            //$loc = $location->province.$location->city.$location->district.$location->isp;
        }else{
            $loc = $location->desc;
        }
        return $loc;
    }

    function getIP()
    {
        static $realip;
        if (isset($_SERVER)){
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])){
                $realip = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $realip = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $realip = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")){
                $realip = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $realip = getenv("HTTP_CLIENT_IP");
            } else {
                $realip = getenv("REMOTE_ADDR");
            }
        }
        return $realip;
    }

}