<?php

namespace frontend\modules\weixin\controllers;
use app\components\WxpayComponents;
use yii\web\Controller;

class OneDayPaController extends Controller
{

    public function actionRecharge($id,$openid){

        if(in_array($id,[10,20,30,50])){
            $order_number = date('YmdHis').uniqid();
            $attach = array('openid'=>$openid,'type'=>2,'total_fee'=>$id);
            $wxpay = new WxpayComponents();
            $wxpay->Wxpay("Vip加速",$order_number,$id/10,json_encode($attach),'vip');
        }
    }

    public function actionRecord(){


    }
}
