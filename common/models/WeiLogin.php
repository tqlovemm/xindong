<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class WeiLogin extends Model
{
    public $openid;
    public $rememberMe = true;

    private $_user = false;


    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {

        return Yii::$app->wuser->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);

    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        $session = Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
        if ($this->_user === false) {
            $this->_user = WeiUser::findByUsername($session->get('flop_openid'));
        }
        return $this->_user;
    }
}
