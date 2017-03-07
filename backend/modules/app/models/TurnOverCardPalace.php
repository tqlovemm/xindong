<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_turn_over_card_palace".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $like
 * @property integer $status
 * @property integer $flag
 * @property integer $like_best
 * @property integer $is_del
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property TurnOverCardMessage[] $turnOverCardMessages
 * @property User $user
 * @property User $like0
 * @property TurnOverCardSuccess[] $turnOverCardSuccesses
 */
class TurnOverCardPalace extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_palace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'like', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'like', 'flag', 'like_best', 'is_del', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户id',
            'like' => '被like的用户ID',
            'flag' => '是否喜欢(1：喜欢，2：不喜欢)',
            'like_best' => '超级喜欢',
            'is_del' => '是否已解除好友关系',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnOverCardMessages()
    {
        return $this->hasMany(TurnOverCardMessage::className(), ['palace_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLike0()
    {
        return $this->hasOne(User::className(), ['id' => 'like']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTurnOverCardSuccesses()
    {
        return $this->hasMany(TurnOverCardSuccess::className(), ['palace_id' => 'id']);
    }
}
