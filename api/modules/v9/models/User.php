<?php

namespace api\modules\v9\models;

use app\components\db\ActiveRecord;
use backend\modules\app\models\UserImage;
use frontend\models\UserData;
use Yii;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $cid
 * @property integer $groupid
 * @property string $username
 * @property string $nickname
 * @property string $cellphone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $invitation
 * @property integer $role
 * @property string $sex
 * @property string $identify
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $none
 * @property string $avatar
 * @property string $openId
 *
 * @property MakeFriend[] $makeFriends
 * @property RechargeRecord[] $rechargeRecords
 * @property TurnOverCardMessage[] $turnOverCardMessages
 * @property TurnOverCardMessage[] $turnOverCardMessages0
 * @property TurnOverCardPalace[] $turnOverCardPalaces
 * @property TurnOverCardPalace[] $turnOverCardPalaces0
 * @property TurnOverCardRecord[] $turnOverCardRecords
 * @property TurnOverCardSuccess[] $turnOverCardSeccuses
 * @property TurnOverCardSuccess[] $turnOverCardSeccuses0
 * @property UserData $userData
 * @property UserFollow[] $userFollows
 * @property UserFollow[] $userFollows0
 * @property UserImage[] $userImages
 * @property UserMessage[] $userMessages
 * @property UserMessage[] $userMessages0
 * @property UserProfile $userProfile
 */
class User extends ActiveRecord
{

    public $address;
    public $birthdate;
    public $mark;
    public $make_friend;
    public $img_url;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'username', 'nickname', 'cellphone', 'password_hash', 'password_reset_token', 'auth_key', 'invitation', 'sex', 'identify', 'email', 'created_at', 'updated_at', 'none', 'avatar', 'openId'], 'required'],
            [['groupid', 'role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['cid'], 'string', 'max' => 250],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['nickname', 'none'], 'string', 'max' => 255],
            [['cellphone'], 'string', 'max' => 11],
            [['password_hash'], 'string', 'max' => 60],
            [['password_reset_token'], 'string', 'max' => 43],
            [['invitation'], 'string', 'max' => 50],
            [['sex'], 'string', 'max' => 10],
            [['identify'], 'string', 'max' => 20],
            [['email', 'openId'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'groupid' => 'Groupid',
            'username' => 'Username',
            'nickname' => 'Nickname',
            'cellphone' => 'Cellphone',
            'sex' => 'Sex',
            'identify' => 'Identify',
            //'avatar' => 'Avatar',
            //'address' => 'address',
        ];
    }

    public function fields()
    {
        return [
            'user_id'=>'id','groupid',
            'nickname'=>function($model){
                if($model['nickname'] == ''){
                    return $model['username'];
                }else{
                    return $model['nickname'];
                }
            },
            'sex','identify',
            'address','birthdate','avatar'=>'img_url'

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImage()
    {
        return $this->hasOne(UserImage::className(), ['user_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMakeFriends()
    {
        return $this->hasMany(MakeFriend::className(), ['user_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnOverCardMessages()
    {
        return $this->hasMany(TurnOverCardMessage::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnOverCardMessages0()
    {
        return $this->hasMany(TurnOverCardMessage::className(), ['from' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPalace1()
    {
        return $this->hasMany(TurnOverCardPalace::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTPalaces2()
    {
        return $this->hasMany(TurnOverCardPalace::className(), ['like' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRecords()
    {
        return $this->hasMany(TurnOverCardRecord::className(), ['user_id' => 'id'])->where(['']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuccess1()
    {
        return $this->hasMany(TurnOverCardSuccess::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuccess2()
    {
        return $this->hasMany(TurnOverCardSuccess::className(), ['beliked' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSuccess3()
    {

        //return TurnOverCardSuccess::find()->where(['beliked'=>'id'])->orwhere(['user_id'=>'id'])->andWhere(['flag'=>1])->All();
        return $this->hasMany(TurnOverCardSuccess::className(), ['beliked' => 'id'])->orWhere(['user_id'=>'id'])->where(['flag'=>1]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getData()
    {
        return $this->hasOne(UserData::className(), ['user_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(UserImage::className(), ['user_id' => 'id']);
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }


}
