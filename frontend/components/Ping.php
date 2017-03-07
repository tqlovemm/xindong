<?php
namespace app\components;

use shiyang\ping\lib\Charge;
use shiyang\ping\lib\Pingpp;
use shiyang\ping\lib\Util\Util;

class Ping
{

    public function pingPp($data = array()){

        $ping_key_path = \Yii::getAlias('@frontend').'/pem/ping_public_key.pem';
        $pub_key_path  = \Yii::getAlias('@frontend').'/web/pem/rsa_private_key.pem';

        Pingpp::setApiKey('sk_live_WnfbvLy5KGKGSO04iPrvPa50');
        Pingpp::setPrivateKeyPath($pub_key_path);

        //webhooks
        $headers = Util::getRequestHeaders();
        $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;

        if(!$signature){

            Charge::create(array(
                'order_no'  => $data['order_no'],
                'amount'    => $data['amount'],
                'app'       => array('id' => 'app_jHqfH4iXzrb5irvT'),
                'channel'   => 'alipay_wap',
                'currency'  => 'cny',
                'client_ip' => '127.0.0.1',
                'subject'   => $data['subject'],
                'body'      => $data['body']
            ));
        }

        //验证webhooks签名

        $data = file_get_contents('php://input');
        $result = $this->verify_signature($data, $signature, $ping_key_path);

        if ($result === 1) {

            // 验证通过
            return $data;

        } else{

            http_response_code(400);
            echo 'verification failed';
            exit;
        }

    }


    protected function verify_signature($raw_data, $signature, $pub_key_path) {
        $pub_key_contents = file_get_contents($pub_key_path);
        // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
        return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
    }













}