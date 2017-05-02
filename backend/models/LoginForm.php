<?php
namespace backend\models;

use common\models\User;
use Yii;
use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verification;
    public $rememberMe = true;

    private $_user = false;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['verification','username', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            ['verification','integer'],
            ['verification','verification'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'username' => '用户名、邮箱或手机号',
            'password' => '密码',
            'rememberMe' => '记住密码',
            'verification' => '验证码',
        ];
    }

    public function verification(){

        $codeModel = UserLoginCode::find()->where(['mobile'=>$this->username])->orderBy('created_at desc')->one();
        /*$session = \Yii::$app->session;
        if(!$session->isActive)
            $session->open();*/
        $save_code = $codeModel->code;
        $save_mobile = $codeModel->mobile;

        if($this->verification!=$save_code){
            return $this->addError('verification','验证码错误');
        }
        if($this->username!=$save_mobile){
            return $this->addError('username','手机号与验证码不匹配');
        }

    }
    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            if (!$user) {
                $this->addError('username', Yii::t('app', 'Username does not exist.'));
            } elseif (!$user->validatePassword($this->password)) {
                $this->addError('password', Yii::t('app', 'Incorrect password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 : 0);
        } else {
            return false;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByUsername($this->username);
        }
        return $this->_user;
    }
}
