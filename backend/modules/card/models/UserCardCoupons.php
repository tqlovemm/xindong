<?php

namespace backend\modules\card\models;

use Yii;

/**
 * This is the model class for table "{{%z_user_card_coupons}}".
 *
 * @property integer $card_id
 * @property integer $user_id
 * @property integer $type
 * @property integer $effect
 * @property integer $condition
 * @property integer $status
 * @property integer $created_at
 * @property integer $expire
 * @property string $admin
 * @property string $description
 */
class UserCardCoupons extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%z_user_card_coupons}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'type', 'condition', 'status', 'created_at', 'expire', 'effect'], 'integer'],
            [['admin'], 'string', 'max' => 32],
            [['description'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'card_id' => 'Card ID',
            'user_id' => 'User ID',
            'type' => 'Type',
            'effect' => 'Effect',
            'condition' => 'Condition',
            'status' => 'Status',
            'created_at' => 'Created At',
            'expire' => 'Expire',
            'admin' => 'Admin',
            'description' => 'Description',
        ];
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->admin = Yii::$app->user->identity->username;
            }
            return true;
        }
        return false;
    }
}
