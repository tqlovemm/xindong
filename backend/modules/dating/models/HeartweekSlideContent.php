<?php

namespace backend\modules\dating\models;

use Yii;

/**
 * This is the model class for table "pre_heartweek_slide_content".
 *
 * @property string $id
 * @property string $album_id
 * @property string $name
 * @property string $thumb
 * @property string $content
 * @property string $path
 * @property string $store_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_cover
 *
 * @property HeartweekContent $album
 */
class HeartweekSlideContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_heartweek_slide_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['album_id', 'created_at', 'created_by', 'is_cover','style'], 'integer'],
            [['name','content'], 'string'],
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
            'album_id' => 'Album ID',
            'name' => 'Name',
            'thumb' => 'Thumb',
            'path' => 'Path',
            'store_name' => 'Store Name',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'is_cover' => 'Is Cover',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAlbum()
    {
        return $this->hasOne(HeartweekContent::className(), ['id' => 'album_id']);
    }
}
