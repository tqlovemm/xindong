<?php

namespace api\modules\v3\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "user".
 *

 * @property string $password_reset_token
 * @property string $cellphone
 */
class User extends ActiveRecord
{

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
            
            [['password_reset_token','cellphone'], 'string', 'max' => 255],
            
        ];
    }

    // 返回的数据格式化
    public function fields()
    {
        $fields = parent::fields();

        return $fields;
    }


    public function attributeLabels()
    {
        return [
            'password_reset_token' => 'Password Reset Token',
            'cellphone' => 'Cellphone',
        ];
    }

}
