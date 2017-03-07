<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/23
 * Time: 10:00
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class UserInfoController extends Controller
{

    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    =>  'item',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionView($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $userInfo = (new Query())->from('pre_user')->select('id as user_id,username,avatar')->where(['id'=>$id])->one();
        if($userInfo){
            $str = [
                'code'  =>  '200',
                'data'   =>  $userInfo,
            ];
            return $str;
        }else{
            $str = [
                'code'  =>  '201',
                'msg'   =>  '用户不存在',
            ];
            return $str;
        }

    }
}