<?php

namespace frontend\modules\weixin\controllers;
use app\components\WxpayComponents;
use yii\web\Controller;

class OneDayPaController extends Controller
{

    public function actionRecharge(){

        $order_number = date('YmdHis').uniqid();
        $attach = array('user_id'=>10000,'type'=>2,'groupid'=>2);
        $wxpay = new WxpayComponents();
        $wxpay->Wxpay("会员升级",$order_number,10000,json_encode($attach),'memberup');
    }

    public function actionRecord(){


    }
}
