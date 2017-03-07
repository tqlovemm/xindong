<?php

namespace frontend\modules\member\models;

use Yii;

/**
 * This is the model class for table "pre_dating_evaluate".
 *
 * @property integer $id
 * @property integer $ccid
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $evaluate
 * @property string $text
 */
class DatingEvaluate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_dating_evaluate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccid', 'user_id', 'text'], 'required'],
            [['ccid', 'user_id', 'created_at', 'evaluate'], 'integer'],
            [['text'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ccid' => 'Ccid',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'evaluate' => 'Evaluate',
            'text' => 'Text',
        ];
    }
}
