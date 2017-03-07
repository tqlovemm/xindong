<?php

namespace app\modules\show\models;

use Yii;

/**
 * This is the model class for table "pre_seeks".
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
 */
class Seeks extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_seeks';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'name', 'thumb', 'path', 'store_name', 'created_at', 'created_by'], 'required'],
            [['album_id', 'created_at', 'created_by', 'is_cover'], 'integer'],
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
            'album_id' => 'Album ID',
            'name' => '主题',
            'thumb' => '简介',
            'path' => 'ID照',
            'store_name' => '存储名',
            'created_at' => '时间',
            'created_by' => '创建人',
            'is_cover' => 'Is Cover',
        ];
    }
}
