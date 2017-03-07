<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/1/20
 * Time: 11:07
 */

namespace frontend\controllers;


use yii\web\Controller;
use yii\myhelper\Easemob;

class EasemobController extends Controller
{


    public function actionIndex(){

        $array = ['username'=>'tqlmm3','password'=>'tq122818'];
        var_dump($this->addUser($array));
        return;

    }
    protected function setMes(){

        $options = array(
            'client_id'  => 'YXA6zamAUIOdEeWcWzkZK3TkBQ',   //你的信息
            'client_secret' => 'YXA6nN7MHrOfmJi8V3viG6s9lG8IYlc',//你的信息
            'org_name' => 'thirtyone' ,//你的信息
            'app_name' => 'chatapp' ,//你的信息
        );
        $e = new Easemob($options);

        return $e;
    }

    protected function getToken(){

        return $this->setMes()->getToken();

    }

    protected function getUser($group_id){

        return $this->setMes()->getGroupUsers($group_id);
    }

    protected function addUser($data){

        return $this->setMes()->addUser($data);

    }

}