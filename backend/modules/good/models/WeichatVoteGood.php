<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "pre_weichat_vote_good".
 *
 * @property integer $id
 * @property integer $vote_id
 * @property string $sayGood
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class WeichatVoteGood extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weichat_vote_good';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vote_id', 'sayGood', 'status'], 'required'],
            [['vote_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['sayGood'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vote_id' => 'Vote ID',
            'sayGood' => 'Say Good',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
