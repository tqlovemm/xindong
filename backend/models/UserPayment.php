<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pre_user_payment".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $payment_img
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 *
 * @property User $user
 */
class UserPayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_payment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'payment_img'], 'required'],
            [['user_id', 'created_at', 'updated_at', 'created_by'], 'integer'],
            [['payment_img'], 'string', 'max' => 50],
            [['extra'], 'string', 'max' => 128]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'payment_img' => 'Payment Img',
            'extra' => '备注',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
                $this->updated_at = time();
                $this->created_by = Yii::$app->user->id;
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
