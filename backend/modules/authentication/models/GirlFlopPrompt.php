<?php

namespace backend\modules\authentication\models;

use Yii;

/**
 * This is the model class for table "pre_girl_flop_prompt".
 *
 * @property integer $id
 * @property string $content
 * @property integer $status
 */
class GirlFlopPrompt extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_girl_flop_prompt';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content'], 'required'],
            [['status'], 'integer'],
            [['content'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'status' => 'Status',
        ];
    }
}
