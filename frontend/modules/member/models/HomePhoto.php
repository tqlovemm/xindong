<?php

namespace frontend\modules\member\models;

use Yii;

/**
 * This is the model class for table "pre_home_photo".
 *
 * @property string $id
 * @property string $album_id
 * @property string $name
 * @property string $thumb
 * @property string $path
 * @property string $store_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_cover
 * @property integer $note
 * @property string $note_by
 */
class HomePhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_home_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'name', 'thumb', 'path', 'store_name', 'created_at', 'created_by', 'note', 'note_by'], 'required'],
            [['album_id', 'created_at', 'created_by', 'is_cover', 'note'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['thumb', 'path', 'store_name'], 'string', 'max' => 255],
            [['note_by'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'album_id' => 'Album ID',
            'name' => 'Name',
            'thumb' => 'Thumb',
            'path' => 'Path',
            'store_name' => 'Store Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'is_cover' => 'Is Cover',
            'note' => 'Note',
            'note_by' => 'Note By',
        ];
    }
}
