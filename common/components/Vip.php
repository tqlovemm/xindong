<?php

namespace common\components;

use frontend\modules\weiuser\models\AddressList;
use frontend\modules\weiuser\models\City;

class Vip
{

    public static function vip_expire($expire){

        $day = floor($expire/86400);
        $hour = floor(($expire%86400)/3600);
        $min = floor((($expire%86400)%3600)/60);
        $second = floor(((($expire%86400)%3600)%60)%60);

        if($day>0){
            $time = $day.'天'.$hour.'时'.$min.'分'.$second.'秒';
        }elseif($hour>0){
            $time = $hour.'时'.$min.'分'.$second.'秒';
        }elseif($min>0){
            $time = $min.'分'.$second.'秒';
        }else{
            $time = $second.'秒';
        }

        return $time;

    }

    public static function vip($vipNumber){

        if($vipNumber==2){
            $vip = "普通会员";
        }elseif($vipNumber==3){
            $vip = "高端会员";
        }elseif($vipNumber==4){
            $vip = "至尊会员";
        }elseif($vipNumber==5){
            $vip = "私人定制";
        }else{
            $vip = "网站会员";
        }
        return $vip;
    }
    public static function vip_type($typeNumber,$shorthand=0){

        if($shorthand!=0){
            if($typeNumber==1){
                $type = "<span class='vip-type' style='background-color:rgba(255, 176, 174, 0.3);'>月</span>";
            }elseif($typeNumber==2){
                $type = "<span class='vip-type' style='background-color:rgba(102, 144, 255, 0.3);'>季</span>";
            }elseif($typeNumber==5){
                $type = "<span class='vip-type' style='background-color:rgba(255, 135, 248, 0.3);'>半</span>";
            }else{
                $type = "<span class='vip-type' style='background-color:rgba(139, 250, 255, 0.3);'>年</span>";
            }
        }else{
            if($typeNumber==1){
                $type = "包月会员";
            }elseif($typeNumber==2){
                $type = "季度会员";
            }elseif($typeNumber==5){
                $type = "半年费会员";
            }else{
                $type = "年费会员";
            }
        }

        return $type;
    }

    public static function specialVip($vipNumber){
        if($vipNumber==2){
            $vip = "普通及以上会员";
        }elseif($vipNumber==3){
            $vip = "高端及以上会员";
        }elseif($vipNumber==4){
            $vip = "至尊及以上会员";
        }elseif($vipNumber==5){
            $vip = "私人定制";
        }else{
            $vip = "网站会员";
        }
        return $vip;
    }

    public static function status($statusNumber){


        if($statusNumber==0){
            $status = "未填写完成";
            $color = "bg-aqua-active";
        }elseif($statusNumber==1){
            $status = "等待审核";
            $color = "bg-yellow";
        }elseif($statusNumber==2){
            $status = "审核通过";
            $color = "bg-green";
        }else{
            $status = "审核失败";
            $color = "bg-red";
        }
        $data = ['color'=>$color,'status'=>$status];
        return $data;
    }

    public static function sign_status($statusNumber){

        if($statusNumber==10){
            $status = "等待审核";
            $color = "bg-aqua-active";
        }elseif($statusNumber==11){
            $status = "审核通过";
            $color = "bg-green";
        }elseif($statusNumber==12){
            $status = "审核失败";
            $color = "bg-red";
        }else{
            $status = "待定";
            $color = "bg-red";
        }
        $data = ['color'=>$color,'status'=>$status];
        return $data;
    }


    public static function time_d($key){

        $arr = [0=>'午夜00点',1=>'凌晨1点',2=>'凌晨2点',3=>'凌晨3点',4=>'凌晨4点',5=>'凌晨5点',6=>'上午6点',
            7=>'上午7点',8=>'上午8点',9=>'上午9点',10=>'上午10点',11=>'上午11点',12=>'中午12点',13=>'下午1点',14=>'下午2点',15=>'下午3点',16=>'下午4点',17=>'下午5点',18=>'下午6点',19=>'晚上7点',20=>'晚上8点',
            21=>'晚上9点',22=>'晚上10点',23=>'晚上11点',24=>'晚上12点'
        ];

        return $arr[$key];
    }

    //新代码使用
    public static function area($code){
        $model = AddressList::findOne($code);
        return !empty($model)?$model->region_name_c:null;
    }

    public static function cnArea($country=null,$province=null,$city=null){

       if($country=="CN"){
           return self::area($province).' '.self::area($city);
       }else{
           if($city!=null){
               return self::area($country).' '.self::area($city);
           }else{
               return self::area($country).' '.self::area($province);
           }
       }
    }

    public static function wholeArea($code){

        $province = "";
        $city = "";
        $model = AddressList::findOne($code);
        if($model->level==0){
            $country = $model->code;
        }elseif($model->level==1){
            $country = $model->country_code;
            $province = $model->code;
        }else{
            $country = $model->country_code;
            $province = $model->upper_region;
            $city = $model->code;
        }
        $area = array('country'=>$country,'province'=>$province,'city'=>$city);
        return $area;
    }

    public static function locationArea(){
       // $ip = isset($_SERVER["HTTP_X_REAL_IP"])?$_SERVER["HTTP_X_REAL_IP"]:$_SERVER["REMOTE_ADDR"];
        return self::GetIpLookup();
    }

    public static function GetIpLookup($ip = '47.90.23.171'){
        $res = @file_get_contents('http://int.dpool.sina.com.cn/iplookup/iplookup.php?format=js&ip=' . $ip);
        if(empty($res)){ return false; }
        $jsonMatches = array();
        preg_match('#\{.+?\}#', $res, $jsonMatches);
        if(!isset($jsonMatches[0])){ return false; }
        $json = json_decode($jsonMatches[0], true);
        if(isset($json['ret']) && $json['ret'] == 1){
            $json['ip'] = $ip;
            unset($json['ret']);
        }else{
            return false;
        }
        return $json;
    }

    public function actionLists($id)
    {
        $option = "";
        $branches = City::find()->where(['fatherId' => [$id]])->asArray()->all();
        if (count($branches) > 0) {
            foreach ($branches as $branch) {
                $option .= "<option value='" . $branch['cityID'] . "'>" . $branch['city'] . "</option>";
            }
        } else {
            $option .= "<option>-</option>";
        }
        echo $option;
    }


    public static function sort(){
        //帖子热度 = (总赞数*0.2+总评论数*0.3+管理员参数*0.4+总阅读数*0.1)*1000/(发布时间距离当前时间的小时差+2)^1.2
        \Yii::$app->db->createCommand("update pre_app_form_thread set total_score=(thumbs_count*0.3+comments_count*0.5+admin_count*0.1+read_count*0.1)/power(((unix_timestamp(now())-created_at)/604800)+2,1.2) where `type`=0")->execute();
    }
}