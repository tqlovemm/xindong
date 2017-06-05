<?php

namespace frontend\modules\weixin\controllers;

use app\components\WxpayComponents;
use yii\web\Controller;

class OneDayPaController extends Controller
{

    public function actionRecharge($id){

        $data = explode('51payo',$id);
        if(in_array($data[0],[10,20,30,50])){

            if($data[0]==10){
                $up_score = 10;
            }elseif($data[0]==20){
                $up_score = 25;
            }elseif($data[0]==30){
                $up_score = 40;
            }else{
                $up_score = 70;
            }

            $order_number = date('YmdHis').uniqid();
            $attach = array('oid'=>$data[1],'pa'=>200,'total_fee'=>$data[0],'up_score'=>$up_score);
            $wxpay = new WxpayComponents();
            $wxpay->Wxpay("Vip加速",$order_number,$data[0]/10,json_encode($attach),'vip');
        }
    }
}
