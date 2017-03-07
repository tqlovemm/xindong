<?php

namespace backend\modules\seventeen\models;

use Yii;

/**
 * This is the model class for table "pre_collecting_17_files_img".
 *
 * @property integer $id
 * @property integer $text_id
 * @property string $img
 * @property integer $type
 *
 * @property Collecting17FilesText $text
 */
class SeventeenFilesImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_17_files_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'img'], 'required'],
            [['text_id', 'type'], 'integer'],
            [['img'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text_id' => '女生编号',
            'img' => '女生上传图片',
            'type' => '图片类型（0为正常图片，1为微信二维码，2为头像）',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getText()
    {
        return $this->hasOne(Collecting17FilesText::className(), ['id' => 'text_id']);
    }
}
