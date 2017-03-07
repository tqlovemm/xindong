<?php

namespace frontend\models;

use Yii;
use common\models\User;
use yii\helpers\ArrayHelper;
use app\models\MemberAddressLink;
/**
 * This is the model class for table "pre_user_profile".
 *
 * @property integer $user_id
 * @property string $weichat
 * @property string $number
 * @property string $birthdate
 * @property string $signature
 * @property string $address
 * @property string $address_1
 * @property string $address_2
 * @property string $address_3
 * @property string $description
 * @property string $mark
 * @property string $make_friend
 * @property string $hobby
 * @property integer $height
 * @property integer $weight
 * @property integer $updated_at
 * @property integer $created_at
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
            [['user_id', 'height', 'weight', 'updated_at', 'created_at'], 'integer'],
            [['birthdate'], 'safe'],
            [['address', 'description'], 'string'],
            [['weichat', 'number','address_1','address_2','address_3'], 'string', 'max' => 50],
            [['signature'], 'string', 'max' => 120],
            [['mark'], 'string', 'max' => 1025],
            [['make_friend', 'hobby'], 'string', 'max' => 1024],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'weichat' => '微信号',
            'number' => '十三编号',
            'file'=>'档案照',
            'birthdate' => '出生日期',
            'signature' => 'Signature',
            'address' => '地址',
            'description' => 'Description',
            'mark' => 'Mark',
            'make_friend' => 'Make Friend',
            'hobby' => 'Hobby',
            'height' => 'Height',
            'weight' => 'Weight',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */



    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getCityList($pid)
    {
        $model = MemberAddressLink::findAll(array('parentid'=>$pid));
        return ArrayHelper::map($model, 'id', 'areaname');
    }
    public function getAddress($id)
    {
        if($id!=''){

            $model = MemberAddressLink::findOne(array('id'=>$id));
            return $model['areaname'];
        }

        return '';

    }

    public function upload()
    {
        if ($this->validate()) {

            Yii::setAlias('@upload', '@frontend/web/uploads/dangan/');

            $path = Yii::$app->user->identity->username.time().rand(10000,99999) . '.' . $this->file->extension;

            $this->file->saveAs(Yii::getAlias('@upload').$path );

            return 'http://13loveme.com'.'/uploads/dangan/'.$path;

        } else {
            return false;
        }
    }
}
