<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_turn_over_card_success".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $beliked
 * @property integer $palace_id
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property User $beliked0
 * @property TurnOverCardPalace $palace
 */
class TurnOverCardSuccess extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_success';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'beliked', 'palace_id', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'beliked', 'palace_id', 'flag', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '用户ID',
            'beliked' => '被喜欢用户ID',
            'palace_id' => '后宫ID',
            'flag' => '是否解除好友关系(1:no,2:yes)',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
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
    public function getBeliked0()
    {
        return $this->hasOne(User::className(), ['id' => 'beliked']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPalace()
    {
        return $this->hasOne(TurnOverCardPalace::className(), ['id' => 'palace_id']);
    }
}
