<?php

namespace backend\modules\card\models;

use backend\models\User;
use Yii;

/**
 * This is the model class for table "{{%z_user_jurisdiction_assignment}}".
 *
 * @property string $item_name
 * @property integer $user_id
 * @property integer $created_at
 *
 * @property AllJurisdictionRoute $itemName
 * @property User $user
 */
class JurisdictionAssignment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%z_user_jurisdiction_assignment}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['item_name', 'user_id'], 'required'],
            [['user_id', 'created_at'], 'integer'],
            [['item_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'item_name' => 'Item Name',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemName()
    {
        return $this->hasOne(AllJurisdictionRoute::className(), ['route' => 'item_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
