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
class ProfileData extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    public function rules()
    {
        return [
            [['address',], 'string'],

        ];
    }
    public function attributeLabels()
    {
        return [
            'address' => 'address',
            'user_id' => 'user id',
        ];
    }

    public function fields()
    {

        return [
           'address'
        ];

    }
}
?>
