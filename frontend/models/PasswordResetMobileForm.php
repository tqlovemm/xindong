<?php
namespace frontend\models;

use Yii;
use app\components\SendTemplateSMS;
use common\models\User;
use yii\base\Model;

/**
 * Password reset mobile  form
 */
class PasswordResetMobileForm extends Model
{
    public $cellphone;
    public $smsCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //手机号码验证
            ['cellphone', 'filter', 'filter' => 'trim'],
            ['cellphone', 'required','on' => ['default','login_sms_mobile'], 'message' => '手机号不可为空！'],
            ['cellphone', 'getMobile','on' => ['default','login_sms_mobile']],
            ['cellphone', 'integer', 'on' => ['login_sms_code']],
            ['cellphone', 'match', 'pattern'=>'/1[3458]{1}\d{9}$/', 'on' => ['default','login_sms_code'], 'message'=>'手机号不合法'],
            ['cellphone', 'string', 'min'=>11,'max' => 11, 'on' => ['default','login_sms_code']],

            //短信验证码验证
            ['smsCode', 'required','on' => ['default','login_sms_code'], 'message' => '验证码不可为空！'],
            ['smsCode', 'integer','on' => ['default','login_sms_code']],
            ['smsCode', 'string', 'min'=>6,'max' => 6,'on' => ['default','login_sms_code']],
            ['smsCode', 'getSmsCode','on' => ['default','login_sms_code']],
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
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'cellphone' => '手机号码',
            'smsCode' => '验证码',
        ];
    }

    /**
     * @param $mobile
     * @param $code
     * @return bool
     */
    public function sendSMS($mobile,$code){
        $user = User::findOne([
            'status' => User::STATUS_ACTIVE,
            'cellphone' => $this->cellphone,
        ]);
        if($user){
            $send = new SendTemplateSMS();
            if($send::send($mobile,array($code,'10'),"1")){
                return true;
            }else{
                return false;
            }
        }
    }

}
