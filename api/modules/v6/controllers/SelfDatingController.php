<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/19
 * Time: 10:06
 */

namespace api\modules\v6\controllers;
use backend\modules\recharge\models\RechargeContent;
use Yii;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;

class SelfDatingController extends ActiveController
{

    public $modelClass = 'api\modules\v6\models\SelfDating';
    public $serializer = [
        'class' =>  'yii\rest\Serializer',
        'collectionEnvelope'    => 'items',
    ];

    public function behaviors(){

        return parent::behaviors();
    }

    public function actions(){

        $actions = parent::actions();
        unset($actions['index'],$actions['view'],$actions['update'],$actions['create'],$actions['delete']);
        return $actions;
    }

    public function actionCreate(){

        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $res = (new Query())->from('{{%user_profile}}')->where(['user_id'=>$model->user_id])->one();
        if($res['flag'] == 0 ){
            Response::show('201','信息未填写完整，不能觅约');
        }elseif( $res['flag'] == 1){
            Response::show('201','信息正在审核中，请稍后再发布觅约');
        }elseif( $res['flag'] == 2){
            //一个月只能觅约一次
            $user_id = $model->user_id;
            $info = (new Query())->select('expire')->from('{{%app_selfdating}}')->where(['user_id'=>$user_id])->one();
            $time = time();
            if($info && $time<$info['expire']){
                Response::show('201','一个月只能发布觅约一次');
            }

            //信息审核通过，发布觅约
            $avatar = (new Query())->select('avatar,sex,groupid,nickname')->from('{{%user}}')->where('id = '.$model->user_id)->one();
            if(!$avatar){
                Response::show('201','该用户不存在');
            }
            $model->expire = strtotime('+1 month');
            $model->avatar = $avatar['avatar'];
            $model->sex = $avatar['sex'];
            $model->level = $avatar['groupid'];
            $model->nickname = $avatar['nickname'];
            $model->created_at = time();
            if(!$model->save()){
                Response::show('201','发布觅约失败');
            }
            $res2 = Yii::$app->db->createCommand('update pre_user_profile set status = 2,updated_at = '.$time.' where user_id = '.$user_id)->execute();
            if(!$res2){
                Response::show('201','更新觅约信息失败');
            }
            Response::show('200','发布觅约成功');

        }else{
            Response::show('201','该用户信息请先完善您的信息');
        }
    }
}