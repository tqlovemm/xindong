<?php

namespace backend\modules\note\models;

use Yii;

/**
 * This is the model class for table "pre_weichat_note_content_detail".
 *
 * @property string $id
 * @property string $noteid
 * @property string $name
 * @property string $thumb
 * @property string $path
 * @property string $store_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_cover
 * @property integer $status
 *
 * @property WeichatNoteContent $note
 */
class WeichatNoteContentDetail extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weichat_note_content_detail';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['noteid', 'name', 'thumb', 'path', 'store_name', 'created_at', 'created_by', 'status'], 'required'],
            [['noteid', 'created_at', 'created_by', 'is_cover', 'status'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['thumb', 'path', 'store_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'noteid' => 'Noteid',
            'name' => 'Name',
            'thumb' => 'Thumb',
            'path' => 'Path',
            'store_name' => 'Store Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'is_cover' => 'Is Cover',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNote()
    {
        return $this->hasOne(WeichatNoteContent::className(), ['id' => 'noteid']);
    }
}
