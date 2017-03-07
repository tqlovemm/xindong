<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_user_profile".
 *
 * @property integer $user_id
 * @property string $number
 * @property integer $worth
 * @property string $file_1
 * @property string $birthdate
 * @property string $signature
 * @property string $address_1
 * @property string $address_2
 * @property string $address_3
 * @property string $address
 * @property string $description
 * @property integer $is_marry
 * @property string $mark
 * @property string $make_friend
 * @property string $hobby
 * @property integer $height
 * @property integer $weight
 * @property integer $flag
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $weichat
 * @property string $app_nopass_msg
 * @property integer $status
 *
 * @property User $user
 * @property UserImage $images
 */
class AppUserProfile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['user_id', 'worth', 'is_marry', 'height', 'weight', 'flag', 'updated_at', 'created_at', 'status'], 'integer'],
            [['birthdate'], 'safe'],
            [['address', 'description'], 'string'],
            [['number', 'weichat','app_nopass_msg'], 'string', 'max' => 50],
            [['file_1'], 'string', 'max' => 250],
            [['signature'], 'string', 'max' => 120],
            [['address_1', 'address_2', 'address_3'], 'string', 'max' => 256],
            [['mark'], 'string', 'max' => 1025],
            [['make_friend', 'hobby'], 'string', 'max' => 1024]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'number' => 'Number',
            'worth' => '密约价格',
            'file_1' => 'File 1',
            'birthdate' => '生日',
            'signature' => '个人签名',
            'address_1' => 'Address 1',
            'address_2' => 'Address 2',
            'address_3' => 'Address 3',
            'address' => 'Address',
            'description' => 'Description',
            'is_marry' => '婚姻情况（0单身，1有女友，2已婚）',
            'mark' => '标签',
            'make_friend' => '交友要求',
            'hobby' => 'Hobby',
            'height' => '身高',
            'weight' => '体重',
            'flag' => 'Flag',
            'app_nopass_msg' => '审核不通过原因',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'weichat' => 'Weichat',
            'status' => '状态值（1为审核中，2为通过，3为不通过）',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(UserImage::className(), ['user_id' => 'user_id']);
    }
}
