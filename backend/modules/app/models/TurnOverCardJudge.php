<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_turn_over_card_judge".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $for_who
 * @property integer $num
 * @property string $mark
 * @property string $judge
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $forWho
 * @property User $user
 */
class TurnOverCardJudge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_judge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'for_who', 'mark', 'judge', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'for_who', 'num', 'flag', 'created_at', 'updated_at'], 'integer'],
            [['mark', 'judge'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '评论者ID',
            'for_who' => '被评论者ID',
            'num' => '给几颗星',
            'mark' => '标签',
            'judge' => '其他',
            'flag' => '是否可见(0:yes,1:no)',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForWho()
    {
        return $this->hasOne(User::className(), ['id' => 'for_who']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
