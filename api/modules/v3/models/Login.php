<?php

namespace api\modules\v3\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property integer $cid
 * @property string $username
 * @property integer $sex
 * @property string $avatar
 * @property string $auth_key
 * @property string $cellphone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $role
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class Login extends ActiveRecord
{

    public $old_password_hash;
    public $type;
    public $new_cellphone;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username','cellphone','password_hash'], 'required'],
            [['role', 'status', 'created_at', 'updated_at','sex','type'], 'integer'],
            [['username', 'avatar', 'password_hash','cellphone', 'password_reset_token','old_password_hash', 'email','nickname','cid','new_cellphone'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 32],

            ['username', 'filter', 'filter' => 'trim'],
            //['username', 'unique', 'targetClass' => '\common\models\User'],
            ['username', 'string', 'max' => 32, 'min' => 2],
            ['username', 'match', 'pattern' => '/^(?!_)(?!.*?_$)(?!\d{2,32}$)[a-z\d_]{2,32}$/i'],

            ['cellphone', 'filter', 'filter' => 'trim'],
            //['cellphone', 'unique', 'targetClass' => '\common\models\User'],

            //['cellphone', 'filter', 'filter' => 'trim'],
            //['cellphone', 'unique', 'targetClass' => '\common\models\User'],
            //['cellphone', 'string', 'max' => 11, 'min' => 8],
            //['cellphone', 'match', 'pattern' => '/1[3458]{1}\d{9}$/'],

            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            //['email', 'unique', 'targetClass' => '\common\models\User']

        ];
    }

    // 返回的数据格式化
    public function fields()
    {
        $fields = parent::fields();
        // remove fields that contain sensitive information
        unset($fields['auth_key'],$fields['avatarid'],$fields['avatartemp']);

        return $fields;
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'CID',
            'username' => 'Username',
            'cellphone' => 'Cellphone',
            'avatar' => 'Avatar',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'role' => 'Role',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

}
