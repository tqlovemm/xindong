<?php

namespace api\modules\v9\models;

use Yii;

/**
 * This is the model class for table "pre_user_profile".
 *
 * @property integer $user_id
 * @property string $number
 * @property integer $worth
 * @property string $dating_no
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
 * @property string $app_nopass_msg
 * @property integer $flag
 * @property integer $updated_at
 * @property integer $created_at
 * @property string $weichat
 * @property integer $status
 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
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
            [['user_id', 'number', 'worth',  'signature', 'address', 'description', 'mark', 'make_friend', 'hobby', 'height', 'weight', 'weichat'], 'required'],
            [['user_id', 'worth', 'is_marry', 'height', 'weight', 'flag', 'updated_at', 'created_at', 'status'], 'integer'],
            [['birthdate'], 'safe'],
            [['address', 'description'], 'string'],
            [['number', 'dating_no', 'app_nopass_msg', 'weichat'], 'string', 'max' => 50],
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
            'worth' => 'Worth',
            'birthdate' => 'Birthdate',
            'signature' => 'Signature',
            'address' => 'Address',
            'description' => 'Description',
            'mark' => 'Mark',
            'make_friend' => 'Make Friend',
            'hobby' => 'Hobby',
            'height' => 'Height',
            'weight' => 'Weight',
            'weichat' => 'Weichat',
            'status' => 'Status',
        ];
    }

    public function fields()
    {
        return [
            'user_id','birthdate','address','mark','make_friend','hobby','height','weight'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
