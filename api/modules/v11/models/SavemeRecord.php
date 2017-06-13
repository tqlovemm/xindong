<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_saveme_record".
 *
 * @property integer $id
 * @property integer $saveme_id
 * @property integer $created_id
 * @property integer $to_userid
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class SavemeRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_saveme_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['saveme_id', 'boy_id', 'girl_id', 'content', 'status'], 'required'],
            [['saveme_id', 'boy_id', 'girl_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saveme_id' => 'Saveme ID',
            'created_id' => 'Created ID',
            'to_userid' => 'To Userid',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
