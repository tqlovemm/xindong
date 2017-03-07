<?php

namespace api\modules\v8\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property integer $cellphone
 * @property string $password_reset_token
 * @property integer $created_at
 * @property integer $updated_at
 */
class User2 extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['password_hash','cellphone','password_reset_token'],'required'],
            [['id','cellphone','created_at'], 'integer'],
            [['password_hash','password_reset_token'], 'string'],
            [['cellphone'], 'match','pattern'=>'/\\s*\\+?\\s*(\\(\\s*\\d+\\s*\\)|\\d+)(\\s*-?\\s*(\\(\\s*\\d+\\s*\\)|\\s*\\d+\\s*))*\\s*$/'],
            ['cellphone', 'unique', 'targetClass' => 'api\modules\v8\models\User2', 'message' => '该手机号已经注册.'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'password_hash' => 'password',
            'password_reset_token' => '验证码',
            'cellphone' => 'cellphone',
            'created_at' => 'created_at',
        ];
    }

    public function fields()
    {

        return [
            'id','cellphone','created_at','password_reset_token','password_hash'
        ];

    }

}
?>
