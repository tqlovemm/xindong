<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 14:18
 */

namespace api\modules\v10\controllers;

use Yii;
use api\modules\v8\models\User2;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class User4Controller extends Controller
{

    public $modelClass = 'api\modules\v8\models\User2';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
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

    public function actionUpdate($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new User2();
        $data = $this->findModel($id);
        if(empty($data)){
            Response::show('201','该用户不存在');
        }
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        if($data['password_reset_token'] === $model->password_reset_token){

            if($data['cellphone'] != null){
                Response::show('201','该用户已绑定手机号');
            }
            if($model->validate()){
                $model->password_hash   = Yii::$app->security->generatePasswordHash($model->password_hash);
                $res = Yii::$app->db->createCommand()->update('{{%user}}',[
                    'password_hash' =>  $model->password_hash,
                    'cellphone'     =>  $model->cellphone,
                ],['id'=>$id])->execute();
                if($res){
                    Response::show('200','操作成功');
                }else{
                    Response::show('201','操作失败');
                }
            }else{
                Response::show('201',array_values($model->getFirstErrors())[0]);
            }

        }else{
            Response::show('201','验证码不正确');
        }
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }
}