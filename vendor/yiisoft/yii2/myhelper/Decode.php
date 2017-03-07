<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 15:54
 */

namespace yii\myhelper;

use Yii;
class Decode
{

    public function decodeDigit($id){

        $header = Yii::$app->request->headers;
        $rsaId = $header->get('sign');
        $rsa = new RSADecode();
        if($rsa->getDecodeRsa($rsaId) != $id){
            return false;
        }
        return true;
    }

}