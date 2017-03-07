<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/18
 * Time: 10:45
 */

namespace frontend\modules\test\controllers;

use Yii;
use yii\myhelper\Easemob;
use yii\web\Controller;

class UploadController extends Controller
{

    public $enableCsrfValidation = false;
    public function actionIndex(){


        return $this->render('index');
    }

    public function actionTest(){

        //$data['img'] = $_FILES['imgPath']['tmp_name'].'/'.$_FILES['imgPath']['name'];
        $data = $_GET;return 1;
        //$result = $this->setMsg()->uploadFile($data);
        //return $result;
        //$data['word'] = Yii::$app->request->post();

        //return $this->render('test',['data'=>$data]);
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