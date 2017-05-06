<?php

namespace common\components;
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
}