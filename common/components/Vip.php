<?php

namespace common\components;
use common\models\AppFormThread;

class Vip
{

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

        if($statusNumber==0){
            $status = "等待审核";
            $color = "bg-aqua-active";
        }elseif($statusNumber==1){
            $status = "审核通过";
            $color = "bg-green";
        }elseif($statusNumber==2){
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
            21=>'晚上9点',22=>'晚上10点',23=>'晚上11点',24=>'晚上12点',
        ];

        return $arr[$key];
    }

    public static function sort(){
        //帖子热度 = (总赞数*0.2+总评论数*0.3+管理员参数*0.4+总阅读数*0.1)*1000/(发布时间距离当前时间的小时差+2)^1.2
        \Yii::$app->db->createCommand("update pre_app_form_thread set total_score=(thumbs_count*0.3+comments_count*0.5+admin_count*0.1+read_count*0.1)/power(((unix_timestamp(now())-created_at)/604800)+2,1.2)")->execute();
    }
}