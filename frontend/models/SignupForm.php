<?php
namespace frontend\models;

use common\models\User;
use yii\base\DynamicModel;
use yii\base\Model;
use Yii;
use yii\myhelper\Random;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $password2;
    public $sex;
    public $nickname;
    public $none;
    public $cellphone;
    public $smsCode;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['username', 'filter', 'filter' => 'trim'],
            //['username', 'required'],
            //['sex', 'required'],
            ['sex', 'string'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '用户名已经被使用！！'],
            ['username', 'string', 'max' => 32, 'min' => 2],
            ['username', 'match', 'pattern' => '/^(?!_)(?!.*?_$)(?!\d{5,32}$)[a-z\d_]{5,32}$/i'],
            ['none','string'],
            ['nickname','string'],

            ['cellphone', 'filter', 'filter' => 'trim'],
            ['cellphone', 'getMobile','on' => ['default','login_sms_mobile']],
            ['cellphone', 'integer', 'on' => ['login_sms_code']],
            ['cellphone', 'match', 'pattern'=>'/1[3456789]{1}\d{9}$/', 'on' => ['default','login_sms_code'], 'message'=>'手机号不合法'],
            ['cellphone', 'string', 'min'=>6,'max' => 11, 'on' => ['default','login_sms_code']],

            //短信验证码验证
            ['smsCode', 'filter', 'filter' => 'trim'],
            //['smsCode', 'required','on' => ['default','login_sms_code'], 'message' => '验证码不可为空！'],
            ['smsCode', 'integer','on' => ['default','login_sms_code']],
            ['smsCode', 'string', 'min'=>6,'max' => 6,'on' => ['default','login_sms_code']],
            ['smsCode', 'getSmsCode','on' => ['default','login_sms_code']],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => '邮箱已经被使用！！'],

            ['password', 'required'],
            ['password', 'string', 'min' => 6],
            ['password2','required'],
            [['password2'], 'compare','compareAttribute'=>'password','message'=>'两次输入密码不一致'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' =>'用户名',
            'nickname' =>'昵称',
            'smsCode' =>'验证码',
            'password' => '密码',
            'password2' => '确认密码',
            'email' => '邮箱',
            'sex' => '性别',
            'cellphone'=>'手机号',
        ];
    }

    public function getSmsCode()
    {
        //检查session是否打开
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        //取得验证码和短信发送时间session
        $signup_sms_code = intval(Yii::$app->session->get('login_sms_code'));
        $signup_sms_time = Yii::$app->session->get('login_sms_time');
        if((time()-$signup_sms_time < 600)&&($this->smsCode==$signup_sms_code)){
            return $signup_sms_code;
        }else{
            $this->addError('smsCode','验证码错误');
        }
    }
    public function getMobile(){
        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
        }
        //取得验证码和短信发送时间session
        $signup_sms_mobile = Yii::$app->session->get('login_sms_mobile');
        if($this->cellphone == $signup_sms_mobile){
            return $signup_sms_mobile;
        }else{
            $this->addError('cellphone','该手机号码非短信验证号码');
        }
    }
    public function randUsername(){
        $username = Random::get_random_code(4,2).Random::get_random_code(3,1);
        if(empty(User::findByUsername($username))){
            return $username;
        }else{
            $this->randUsername();
        }
    }
    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        $pre_url = Yii::$app->params['appimages'];
        if ($this->validate()) {

            $user = new User();
            $user->username = $user->nickname = $this->randUsername();
            $user->sex = 0;
            $user->cellphone = $this->cellphone;
            $user->none = md5(md5($this->password).'13loveme');
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->avatar = $pre_url.'uploads/user/avatar/default/' . rand(1, 40) . '.jpg';
            $user->save();
            return $user;
        }
        return null;
    }

    public function emailSignup(){
        $pre_url = Yii::$app->params['appimages'];
        if ($this->validate()) {
            if($this->email==''){
                $this->addError('cellphone','该手机号码非短信验证号码');
            }
            $user = new User();
            $user->username = $user->nickname = $this->randUsername();
            $user->sex = 0;
            $user->email = $this->email;
            $user->none = md5(md5($this->password).'13loveme');
            $user->setPassword($this->password);
            $user->generateAuthKey();
            $user->avatar = $pre_url.'uploads/user/avatar/default/' . rand(1, 40) . '.jpg';
            $user->save();
            return $user;
        }
        var_dump($this->errors);

        return null;

    }
}
