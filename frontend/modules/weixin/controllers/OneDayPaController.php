<?php

namespace frontend\modules\weixin\controllers;
use app\components\WxpayComponents;
use yii\web\Controller;

class OneDayPaController extends Controller
{

    public function actionRecharge($id){

        if(in_array($id,[10,20,30,50])){
            $order_number = date('YmdHis').uniqid();
            $attach = array('user_id'=>10000,'type'=>2,'groupid'=>2);
            $wxpay = new WxpayComponents();
            $wxpay->Wxpay("会员升级",$order_number,$id/10,json_encode($attach),'memberup');
        }
    }

    public function actionRecord(){


    }
}
