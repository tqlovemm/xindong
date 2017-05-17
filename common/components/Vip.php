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

    public static function sort(){
        //帖子热度 = (总赞数*0.2+总评论数*0.3+管理员参数*0.4+总阅读数*0.1)*1000/(发布时间距离当前时间的小时差+2)^1.2
        \Yii::$app->db->createCommand("update pre_app_form_thread set total_score=(thumbs_count*0.3+comments_count*0.5+admin_count*0.1+read_count*0.1)/power(((unix_timestamp(now())-created_at)/3600),1.1)")->execute();
    }
}