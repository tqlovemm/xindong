<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_turn_over_card_message".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $from
 * @property integer $palace_id
 * @property string $message
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property TurnOverCardPalace $palace
 */
class TurnOverCardMessage extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_message';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'from', 'palace_id', 'message', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'from', 'palace_id', 'flag', 'created_at', 'updated_at'], 'integer'],
            [['message'], 'string', 'max' => 500]
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
            'from' => 'From',
            'palace_id' => 'Palace ID',
            'message' => 'Message',
            'flag' => 'Flag',
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
    public function getPalace()
    {
        return $this->hasOne(TurnOverCardPalace::className(), ['id' => 'palace_id']);
    }
}
