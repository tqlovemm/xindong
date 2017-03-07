<?php
namespace app\components;

use yii\myhelper\Jssdk;
use yii\wxpay\lib\WxPayApi;
use yii\wxpay\WxPayJsApiPay;
use yii\wxpay\lib\WxPayUnifiedOrder;
use yii\wxpay\lib\WxPayConfig;
use Yii;
class WxpayComponents
{

    public function Wxpay($good_body,$trade_no,$total_fee,$attach,$tag){

        //①、获取用户openid

        $tools = new WxPayJsApiPay();
        $openId = $tools->GetOpenid();

        //②、统一下单
        $input = new WxPayUnifiedOrder();
        $input->SetBody($good_body);
        $input->SetAttach($attach);
        $input->SetOut_trade_no($trade_no);
        $input->SetTotal_fee($total_fee);
        $input->SetTime_start(date("YmdHis"));
        $input->SetTime_expire(date("YmdHis", time() + 600));
        $input->SetNotify_url("http://13loveme.com/notify.php");
        $input->SetGoods_tag($tag);
        $input->SetTrade_type("JSAPI");
        $input->SetOpenid($openId);
        $order = WxPayApi::unifiedOrder($input);
        $jsApiParameters = $tools->GetJsApiParameters($order);
        echo "<script>

            //调用微信JS api 支付
            function jsApiCall(){

                WeixinJSBridge.invoke(
                    'getBrandWCPayRequest',
                    $jsApiParameters,
                    function(res){
                    
                        WeixinJSBridge.log(res.err_msg);
                        if(res.err_msg == 'get_brand_wcpay_request:ok' ) {
                        
                            alert('支付成功');
                        } 
                        if(res.err_msg == 'get_brand_wcpay_request:cancel' ) {
                        
                            alert('取消支付');
                        } 
                        //alert(res.err_code+res.err_desc+res.err_msg);
                    });
            }

            function callpay()
            {
                if (typeof WeixinJSBridge == 'undefined'){
                    if( document.addEventListener ){
                        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
                    }else if (document.attachEvent){
                        document.attachEvent('WeixinJSBridgeReady', jsApiCall);
                        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
                    }
                }else{
                    jsApiCall();
                }
            }
            callpay()
        </script>";
    }

    public function judgeCookie(){
        $cookie = Yii::$app->request->cookies;
        $this->openid = $cookie->getValue('openid');
        $this->nickname = $cookie->getValue('nickname');
        $this->headimgurl = $cookie->getValue('headimgurl');
        if(!empty($this->openid)&&!empty($this->nickname)&&!empty($this->headimgurl)){
            $jssdk = new Jssdk();
            $this->signPackage = $jssdk->getSignPackage();
            return true;
        }
        return false;
    }
    public function addCookie($cookie_name,$cookie_value){

        $cookies = Yii::$app->response->cookies;
        $cookie = Yii::$app->request->cookies;
        if(empty($cookie->get($cookie_name))){
            $cookies->add(new \yii\web\Cookie([
                'name' => $cookie_name,
                'value' => $cookie_value,
                'expire'=>time()+3600*24*365,
            ]));
        }

    }
}
