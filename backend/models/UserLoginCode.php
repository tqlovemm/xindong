<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pre_user_admin_login_code".
 *
 * @property integer $id
 * @property string $mobile
 * @property integer $code
 * @property integer $created_at
 */
class UserLoginCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_admin_login_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mobile', 'code'], 'required'],
            [['code', 'created_at'], 'integer'],
            [['mobile'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'mobile' => 'Mobile',
            'code' => 'Code',
            'created_at' => 'Created At',
        ];
    }


    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
