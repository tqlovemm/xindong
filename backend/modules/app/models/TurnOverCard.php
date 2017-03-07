<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_turn_over_card".
 *
 * @property integer $id
 * @property integer $turn_over_time
 * @property integer $send
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 */
class TurnOverCard extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['turn_over_time', 'send',], 'required'],
            [['turn_over_time', 'send', 'flag', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'turn_over_time' => '每天最多能翻牌的次数',
            'send' => '每天超级喜欢的个数',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
                $this->flag = 0;
            }
            return true;
        }
        return false;
    }
}
