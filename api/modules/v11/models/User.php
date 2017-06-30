<?php

namespace api\modules\v11\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use backend\modules\app\models\UserImage;
use api\modules\v9\models\UserProfile;
use api\modules\v11\models\GirlFlopBoy;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property integer $cid
 * @property string $username
 * @property string $nickname
 * @property string $avatar
 * @property string $auth_key
 */
class User extends ActiveRecord  implements IdentityInterface
{
    public $address;
    public $birthdate;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['cid' => $token]);
    }

    public function getId()
    {
        return $this->id;
    }

    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['username', 'avatar','nickname','cid'], 'string', 'max' => 255],
        ];
    }

    // 返回的数据格式化
    public function fields()
    {
        return [
            'id','username','avatar','nickname','sex','cid','groupid',
            'address','birthdate','avatar'
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'nickname' => 'Nickname',
            'cid' => 'Cid',
            'avatar' => 'Avatar',
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
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBoylike()
    {
        return $this->hasOne(GirlFlopBoy::className(), ['user_id' => 'id']);
    }
}
