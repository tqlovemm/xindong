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
class User2 extends ActiveRecord  implements IdentityInterface
{
    public $_profile;

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
        $this->_profile = UserProfile::findOne($this->id);
        return [
            'user_id'=>'id','username','avatar','nickname','sex','groupid','cid',
            'address'=>function(){
                return $this->_profile->address;
            },
            'birthdate'=>function(){
                return $this->_profile->birthdate;
            },
            'flop_avatar'=>function(){
                $imageModel = UserImage::findOne(['user_id'=>$this->id]);
                return $imageModel->img_url;
            }
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
