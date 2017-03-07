<?php

namespace api\modules\v3\controllers;
use common\models\User;
use Yii;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\myhelper\Easemob;
use yii\myhelper\Response;
class LoginController extends ActiveController
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
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
    public static function findByUsername($username)
    {
        if(is_numeric($username)) {

            $param = 'cellphone';

        }else{

            $param = 'username';
        }

        return User::findOne([$param => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function actionView($id){

        $user = self::findByUsername($id);

        $password = Yii::$app->request->get('password');
        $cid = Yii::$app->request->get('cid');

        if($user){

            $hash = Yii::$app->security->validatePassword($password,$user['password_hash']);

            if($hash){
                if(!empty($cid)&&strlen($cid)>=32){

                    Yii::$app->db->createCommand("update {{%user}} set cid='$cid' where username='$id'")->execute();

                    $data = array(
                        'id'=>$user['id'],
                        'cid'=>$user['cid'],
                        'username'=>$user['username'],
                        'nickname'=>$user['nickname'],
                        'none'=>$user['none'],
                        'cellphone'=>$user['cellphone'],
                        'email'=>$user['email'],
                        'sex'=>$user['sex'],
                        'avatar'=>$user['avatar'],
                    );
                    exit(Response::show(202,"login success",$data));

                }

                exit(Response::show(601,"update fail","非法操作"));

            }

            exit(Response::show(403,"password error"));

        }
        exit(Response::show(402,"user does not exist"));
   
    }

    public function actionUpdate($id){

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

                        return array_values($model->getFirstErrors())[0];

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

                exit(Response::show(603,"update fail","原密码不正确"));

            }

            exit(Response::show(601,"update fail","非法操作"));


        }elseif(!empty($password_hash)&&!empty($model->type)&&$model->type==25112){

            $password_reset_token = Yii::$app->request->post('password_reset_token');
            
            if(!empty($password_reset_token)&&!empty($model->new_cellphone)){

                $reset_token = (new Query())->select('cid,password_hash,cellphone')->from("{{%user}}")->where(['id'=>$id,'password_reset_token'=>$model->password_reset_token])->one();

                if($model->new_cellphone!=$reset_token['cellphone']){

                    exit(Response::show(605,"update fail","手机号码与注册手机号不符"));
                }

                if(!empty($reset_token)){

                    if (!$model->save()) {

                        return array_values($model->getFirstErrors())[0];

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

                exit(Response::show(602,"update fail","验证码不正确"));

            }

            exit(Response::show(601,"update fail","非法操作"));

        }else{

            exit(Response::show(601,"update fail","非法操作"));

        }

    }

    public function actionCreate(){

        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->none = md5(md5($model->password_hash).'13loveme');
        $model->password_hash = Yii::$app->getSecurity()->generatePasswordHash($model->password_hash);
        $model->avatar = Yii::$app->params['hostname']."/uploads/user/avatar/default/".rand(0,40).'.jpg';
        $model->auth_key = Yii::$app->security->generateRandomString();

        //$query = (new Query())->select('cellphone')->from('{{%user}}')->where(['cellphone'=>$model->cellphone])->one();

        if($this->onlyAttribute($model->cellphone)){

            exit(Response::show(406,"create fail","该手机号码已被注册"));
        }
        if($this->onlyAttribute($model->username)){

            exit(Response::show(401,"create fail","该用户名已被注册"));
        }
        if($this->onlyAttribute($model->email)){

            exit(Response::show(400,"create fail","该邮箱已被注册"));
        }

        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }else{

            Yii::$app->db->createCommand()->insert('{{%user_profile}}', [
                'user_id' => $model->id
            ])->execute();

            Yii::$app->db->createCommand()->insert('{{%user_data}}', [
                'user_id' => $model->id,
            ])->execute();

        }
        $array = ['username'=>$model->username,'password'=>$model->none];
        $this->setMes()->addUser($array);
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
        exit(Response::show(202,"create success",$data));

    }

    protected function onlyAttribute($attribute){

        if (strpos($attribute, '@')) {
            $param = 'email';
        } elseif(is_numeric($attribute)) {
            $param = 'cellphone';
        }else{
            $param = 'username';
        }
        if(!empty(User::find()->where("$param=:$param",[$param=>$attribute])->asArray()->one())){

            return true;

        }else{

            return false;
        }

    }
    protected function setMes(){

        $options = array(
            'client_id'  => Yii::$app->params['client_id'],   //你的信息
            'client_secret' => Yii::$app->params['client_secret'],//你的信息
            'org_name' => Yii::$app->params['org_name'],//你的信息
            'app_name' => Yii::$app->params['app_name'] ,//你的信息
        );
        $e = new Easemob($options);

        return $e;
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