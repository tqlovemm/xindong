<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 16:10
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\myhelper\Decode;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class LoginController extends Controller
{

    public $modelClass = 'api\modules\v3\models\Login';
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
        $model = $this->findModel($id);
        $password_hash = Yii::$app->request->post('password_hash');
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);

        if(!empty($password_hash)&&!empty($model->type)&&$model->type==13001){

            if(!empty($model->old_password_hash)){

                $user_cid = (new Query())->select('password_hash')->from("{{%user}}")->where(['id'=>$id])->one();

                $hash = Yii::$app->security->validatePassword($model->old_password_hash,$user_cid['password_hash']);

                if($hash){


                    if (!$model->save()) {

                        exit(Response::show(606,"密码修改失败"));

                    }

                    $data = array(
                        'id'=>$model->id,
                        'cid'=>$model->cid,
                        'username'=>$model->username,
                        'nickname'=>$model->nickname,
                        'none'=>$model->none,
                        'cellphone'=>$model->cellphone,
                        'email'=>$model->email,
                        'sex'=>$model->sex,
                        'avatar'=>$model->avatar,

                    );

                    exit(Response::show(202,"更新成功",$data));

                }

                exit(Response::show(603,"原密码不正确","原密码不正确"));

            }

            exit(Response::show(601,"非法操作","非法操作"));


        }elseif(!empty($password_hash)&&!empty($model->type)&&$model->type==25112){

            $password_reset_token = Yii::$app->request->post('password_reset_token');

            if(!empty($password_reset_token)&&!empty($model->new_cellphone)){

                $reset_token = (new Query())->select('cid,password_hash,cellphone')->from("{{%user}}")->where(['id'=>$id,'password_reset_token'=>$model->password_reset_token])->one();

                if($model->new_cellphone!=$reset_token['cellphone']){

                    exit(Response::show(605,"手机号码与注册手机号不符","手机号码与注册手机号不符"));
                }

                if(!empty($reset_token)){

                    if (!$model->save()) {

                        exit(Response::show(604,"手机号码修改失败"));

                    }

                    $data = array(
                        'id'=>$model->id,
                        'cid'=>$model->cid,
                        'username'=>$model->username,
                        'nickname'=>$model->nickname,
                        'none'=>$model->none,
                        'cellphone'=>$model->cellphone,
                        'email'=>$model->email,
                        'sex'=>$model->sex,
                        'avatar'=>$model->avatar,

                    );

                    exit(Response::show(202,"update success",$data));

                }

                exit(Response::show(602,"验证码不正确","验证码不正确"));

            }

            exit(Response::show(601,"非法操作","非法操作"));

        }else{

            exit(Response::show(601,"非法操作","非法操作"));

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