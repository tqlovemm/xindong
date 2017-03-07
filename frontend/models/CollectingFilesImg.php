<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_collecting_files_img".
 *
 * @property integer $id
 * @property integer $text_id
 * @property string $img
 * @property string $thumb_img
 *
 * @property CollectingFilesText $text
 */
class CollectingFilesImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_files_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'img'], 'required'],
            [['text_id'], 'integer'],
            [['img','thumb_img'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'text_id' => 'Text ID',
            'img' => 'Img',
            'thumb_img' => 'Thumb Img',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getText()
    {
        return $this->hasOne(CollectingFilesText::className(), ['id' => 'text_id']);
    }
}
