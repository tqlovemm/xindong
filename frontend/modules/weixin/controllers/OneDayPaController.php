<?php

namespace frontend\modules\weixin\controllers;
use app\components\WxpayComponents;
use yii\web\Controller;

class OneDayPaController extends Controller
{

    public function actionRecharge($id){

        $data = explode('51payo',$id);

        if(in_array($data[0],[10,20,30,50])){
            $order_number = date('YmdHis').uniqid();
            $attach = array('oid'=>$data[1],'type'=>2,'total_fee'=>$data[0]);
            $wxpay = new WxpayComponents();
            $wxpay->Wxpay("Vip加速",$order_number,$data[0]/10,json_encode($attach),'vip');
        }
    }

    public function actionRecord(){


    }
}
