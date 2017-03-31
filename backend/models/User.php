<?php

namespace backend\models;

use app\models\JiecaobiNotice;
use frontend\models\UserData;
use frontend\models\UserProfile;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $cid
 * @property string $nickname
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property integer $role
 * @property integer $groupid
 * @property string $email
 * @property string $cellphone
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $avatar
 * @property integer $sex
 * @property string $identify
 * @property UserProfile $userProfile
 * @property UserData $userData
 */
class User extends \yii\db\ActiveRecord
{
    public $new_password;
    public $number;

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
            [['role', 'status', 'created_at','groupid', 'updated_at', 'sex'], 'integer'],
            [['username','nickname'], 'string', 'max' => 32],
            [['password_hash', 'new_password', 'password_reset_token', 'auth_key'], 'string', 'max' => 255],
            [['email','cid','nickname','identify'], 'string', 'max' => 64],
            [['avatar','cellphone'], 'string'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => Yii::t('app', 'Username'),
            'nickname' => Yii::t('app', 'Nickname'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'new_password' => Yii::t('app', 'New Password'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'groupid' => '用户等级',
            'identify' => 'Identify',
            'role' => Yii::t('app', 'Role'),
            'email' => Yii::t('app', 'Email'),
            'cellphone' => Yii::t('app', 'Cellphone'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'avatar' => Yii::t('app', 'Avatar'),
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */

    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    public static function getId($number){

        $user = UserProfile::findOne(['number'=>$number]);
        if(empty($user)){
            return '';
        }
        return $user->user_id;
    }

    public static function getIds($number){

        $user = ArrayHelper::map(UserProfile::find()->where(['like','number',$number])->asArray()->all(),'user_id','user_id');
        return $user;
    }

    public static function getNumber($id){

        $user = UserProfile::findOne($id);
        if(empty($user)){
            return '';
        }
        return $user->number;
    }
    public static function getVip($id){

        $user = User::findOne($id);
        if(empty($user)){
            return '';
        }
        return $user->groupid;
    }
    public static function getUsername($id){
        $username = User::findOne($id);
        return $username->username;
    }
    public function getUserData()
    {
        return $this->hasOne(UserData::className(), ['user_id' => 'id']);
    }
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

}
