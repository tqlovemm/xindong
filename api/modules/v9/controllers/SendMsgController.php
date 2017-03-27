<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 17:27
 */

namespace api\modules\v9\controllers;

use Yii;
use yii\base\Exception;
use yii\myhelper\Easemob;
use yii\myhelper\Response;
use yii\rest\ActiveController;
use yii\web\UploadedFile;

class SendMsgController extends ActiveController
{

    public $modelClass = '';
    public function behaviors(){

        return parent::behaviors();
    }

    public function actions(){

        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['update'],$actions['create'],$actions['delete']);
        return $actions;
    }

    protected function array2object($obj){

        $arr = array();
        if(is_object($obj)){
            foreach($obj as $k=>$item){
                $arr[$k] = $item;
            }
            return $arr;
        }else{
            return 'error';
        }
    }
    function getImage($url,$save_dir='',$filename='',$type=0){
        if(trim($url)==''){
            return array('file_name'=>'','save_path'=>'','error'=>1);
        }
        if(trim($save_dir)==''){
            $save_dir='./';
        }
        $filename=md5(rand(1000,9999).time()).'.jpg';

        if(0!==strrpos($save_dir,'/')){
            $save_dir.='/uploads/';
        }
        //创建保存目录
        if(!file_exists($save_dir)&&!mkdir($save_dir,0777,true)){
            return array('file_name'=>'','save_path'=>'','error'=>5);
        }
        //获取远程文件所采用的方法
        if($type){
            $ch=curl_init();
            $timeout=5;
            curl_setopt($ch,CURLOPT_URL,$url);
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
            $img=curl_exec($ch);
            curl_close($ch);
        }else{
            ob_start();
            readfile($url);
            $img=ob_get_contents();
            ob_end_clean();
        }
        //$size=strlen($img);
        //文件大小
        $fp2=@fopen($save_dir.$filename,'a');
        fwrite($fp2,$img);
        fclose($fp2);
        unset($img,$url);
        return array('file_name'=>$filename,'save_path'=>$save_dir.$filename,'error'=>0);
    }

    public function actionCreate(){
        //$data = json_decode($_POST,true);
      // Response::show('205',$_POST);
        $data = array();
        $data['imgPath'] = $_POST['imgPath'];
        $data['username'] = $_POST['username'];
        $data['word'] = $_POST['word'];
        if(empty($data['imgPath']) || empty($data['username'])){
            Response::show('201','图片和发送的用户名不能为空');
        }
        $msg1 = array();
        if(!empty($data['imgPath'])){

            try{

                $fileImg = $this->getImage($data['imgPath']);
                $iamge = "/home/wwwroot/xindong/api/web/uploads/$fileImg[file_name]";
                //上传图片
                $result = $this->setMsg()->uploadFile($iamge);


            }catch (Exception $e){
                return $e->getMessage();
            }

            $result = $result[0];
            $entities = $this->array2object($result->entities[0]);
            if($entities == 'error'){
                $result['code'] = '201';
                return $result;
            }
            $uri = $result->uri;

            $uuid = $result->entities[0]->uuid;

            $msg1['target_type']    = "users";
            $msg1['target'] = [$data['username']];
            $msg1['msg']    = [
                'type'      =>  'img',
                'url'       =>  $uri.'/'.$uuid,
                'filename'  =>  time().'.jpg',
                'secret'    =>  $entities['share-secret'],
                'size'      =>  [
                    'width'  =>     480,
                    'height' =>     720,
                ],
            ];
            $msg1['from']   =  'shisan-kefu';

            //发送图文
            $this->setMsg()->sendImage($msg1);

            if(!empty($data['word'])){

                $text['target_type'] = "users";
                $text['target'] = [$data['username']];
                $text['msg'] = [
                    'type' => 'txt',
                    'msg' => $data['word'],
                ];
                $text['from'] = "shisan-kefu";
                $this->setMsg()->sendText($text);
            }
            Response::show('200','发送成功');
        }else{
            Response::show('201','没有上传图片');
        }

    }

    protected function setMsg(){

        $param = [
            'client_id' =>  Yii::$app->params['client_id'],
            'client_secret' =>  Yii::$app->params['client_secret'],
            'org_name' =>  Yii::$app->params['org_name'],
            'app_name' =>  Yii::$app->params['app_name'],
        ];

        $e = new Easemob($param);
        return $e;
    }

}