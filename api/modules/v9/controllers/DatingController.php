<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/16
 * Time: 17:00
 */

namespace api\modules\v9\controllers;

use api\modules\v5\models\User;
use Yii;
use yii\db\Query;
use yii\myhelper\Response;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class DatingController extends ActiveController
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

    public function actionView($id){

        $user = User::find()->select('id,groupid,sex')->where(['id'=>$id])->one();
        $time = time();
        //一个月觅约一次
        $dating = (new Query())->select('expire,status')
                ->from('{{%app_selfdating}}')
                ->where(['user_id'=>$id,'status'=>0])
                ->andWhere("status > {$time}")
                ->count();

        if($dating){
            Response::show('201','您一个月只需发布一次觅约');
        }

        if($user['groupid'] < 2 && $user['sex'] == 0){

            Response::show('201','您的等级不够，请先升级为会员');
        }

        Response::show('200','操作成功');

    }

}