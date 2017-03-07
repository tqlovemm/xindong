<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "pre_user_how_play".
 *
 * @property integer $id
 * @property string $title
 * @property string $instruction
 * @property string $rule
 * @property string $inline_time
 * @property string $weibo
 * @property string $explain
 * @property string $flag
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserHowPlay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_how_play';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'instruction', 'rule', 'inline_time', 'weibo', 'explain'], 'required'],
            [['instruction', 'rule', 'inline_time', 'weibo'], 'string'],
            [['created_at', 'updated_at','flag'], 'integer'],
            [['title', 'explain'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'instruction' => 'Instruction',
            'rule' => 'Rule',
            'inline_time' => 'Inline Time',
            'weibo' => 'Weibo',
            'explain' => 'Explain',
            'flag' => 'flag',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }
}
