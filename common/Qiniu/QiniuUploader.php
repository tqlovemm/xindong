<?php
namespace common\Qiniu;

use common\Qiniu\Storage\BucketManager;
use common\Qiniu\Storage\UploadManager;
use yii\myhelper\WaterMark;

class QiniuUploader
{
    private $accessKey;
    private $secretKey;
    private $form_name;


    public function __construct($form_name,$accessKey,$secretKey)
    {
        $this->accessKey = $accessKey;
        $this->secretKey = $secretKey;
        $this->form_name = $form_name;

    }

    protected function Auth(){

        $auth = new Auth($this->accessKey, $this->secretKey);

        return $auth;
    }

    public function upload($bucket,$key){

        $file_name = $_FILES[$this->form_name]['name'];
        $filePath= $_FILES[$this->form_name]['tmp_name'];

        $upToken = $this->Auth()->uploadToken($bucket);
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($upToken, $key.'_'.md5($file_name.rand(1000,9999)), $filePath);
        if ($err !== null) {
            var_dump($err);
        } else {
            return $ret;
        }

    }
    public function upload_water($bucket,$key){

        $file_name = $_FILES[$this->form_name]['name'];
        $filePath= $_FILES[$this->form_name]['tmp_name'];
        $watermark = new WaterMark();
        $watermark->imgMark($filePath,$filePath);
        $upToken = $this->Auth()->uploadToken($bucket);
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($upToken, $key.'_'.md5($file_name.rand(1000,9999)), $filePath);
        if ($err !== null) {
            var_dump($err);
        } else {
            return $ret;
        }

    }

    public function upload_app($bucket,$key,$filePath){

        $upToken = $this->Auth()->uploadToken($bucket);
        $uploadMgr = new UploadManager();
        list($ret, $err) = $uploadMgr->putFile($upToken, $key, $filePath);
        if ($err !== null) {
            var_dump($err);
        } else {
            return $ret;
        }
    }

    public function delete($bucket,$key){

        $deleteImg = new BucketManager($this->Auth());
        $deleteImg->delete($bucket,$key);
    }


}