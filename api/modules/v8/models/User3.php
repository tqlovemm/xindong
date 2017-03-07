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
class User3 extends ActiveRecord
{
    public $addr;
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['username','nickname','avatar'], 'string'],
            [['sex'], 'integer'],

        ];
    }
    public function attributeLabels()
    {
        return [

            'username' => 'username',
            'nickname' => 'nickname',
            'avatar' => 'avatar',
            'sex' => 'sex',
            'address' => 'address',
        ];
    }

    public function fields()
    {

        return [
            'username','nickname','avatar','sex','address'=>'addr',
        ];

    }

    public function getAddress(){

        return $this->hasMany(ProfileData::className(), ['user_id' => 'id']);
    }

}
?>
