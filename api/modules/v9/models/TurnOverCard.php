<?php

namespace api\modules\v9\models;

use app\components\db\ActiveRecord;
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
class TurnOverCard extends ActiveRecord
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
            [['turn_over_time', 'send'], 'required'],
            [['turn_over_time','flag', 'send', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'turn_over_time' => '每天翻牌次数',
            'send' => '推送个数',
            'flag' => 'flag',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'id','turn_over_time','send','flag','created_at','updated_at'
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

}
