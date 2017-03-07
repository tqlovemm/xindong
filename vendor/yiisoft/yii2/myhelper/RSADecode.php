<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/17
 * Time: 15:44
 */
namespace yii\myhelper;
use Yii;

class RSADecode
{

    public function getPublicKey(){

        $publicKeyPath = Yii::getAlias('@api/config/').'app_public_key.pem';
        $publicKey  = openssl_pkey_get_public(file_get_contents($publicKeyPath));

        return $publicKey;
    }

    public function getPrivateKey(){

        $privateKeyPath = Yii::getAlias('@api/config/').'app_private_key.pem';
        $privateKey = openssl_pkey_get_private(file_get_contents($privateKeyPath));

        return $privateKey;
    }

    /**
     * RSA 加密
     * $id 加密的内容
    */
    public function getEncodeRsa($id){

        $encryptData = '';
        if(openssl_private_encrypt($id,$encryptData,$this->getPrivateKey())){

            return $encryptData;
        }else{

            return false;
        }
    }

    /**
     * RSA 解密
     * $encryptData 解密的内容
     */
    public function getDecodeRsa($encryptData = ''){

        $decryptData = '';
        if(openssl_private_decrypt(base64_decode($encryptData),$decryptData,$this->getPrivateKey())){

            return $decryptData;
        }else{

            return false;
        }

    }
}