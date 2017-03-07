<?php

namespace api\modules\v5\models;
use app\components\db\ActiveRecord;
use frontend\models\UserProfile;
use Yii;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $none
 * @property string $avatar
 * @property string $cellphone
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class User extends ActiveRecord
{

    public $birthdate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return "{{%user}}";
    }

    /**
     * Define rules for validation
     */
    public function rules()
    {
        return [
            [['username', 'password_hash','cellphone','avatar','sex','birthdate'], 'required'],
            //[['avatar'],'required','requiredValue'=>'必填字段','message'=>'avatar必须填写'],
            [['username','password_hash','none','avatar','birthdate','cid','nickname','email','identify'], 'string'],
            [['created_at','updated_at','status'], 'integer'],
            [['cellphone'], 'match','pattern'=>'/\\s*\\+?\\s*(\\(\\s*\\d+\\s*\\)|\\d+)(\\s*-?\\s*(\\(\\s*\\d+\\s*\\)|\\s*\\d+\\s*))*\\s*$/'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该用户名已注册.'],
            ['cellphone', 'unique', 'targetClass' => '\common\models\User', 'message' => '该手机号已经注册.'],


        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'groupid' => 'groupid',
            'password_hash' => 'Password',
            'none' => 'Easemob Password',
            'status' => 'Status',
            'birthdate' => 'birthdate',
            'nickname'  =>  'nickname',
            'cellphone'=>'cellphone',
            'email'=>'email',
            'identify'=>'identify',
            'avatar'    =>  'avatar',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'sex'   =>  'sex',
            'cid'   =>  'cid',
        ];
    }

    public function fields()
    {
        return [
            'id',
            'username',
            'nickname',
            'groupid',
            'birthdate',
            'email',
            'identify',
            'avatar',
            'password_hash',
            'none',
            'cellphone',
            'created_at',
            'updated_at',
            'sex',
            'cid'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

}