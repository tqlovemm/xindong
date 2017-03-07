<?php

namespace frontend\models;

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
class CollectingSeventeenFilesImg extends \yii\db\ActiveRecord
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
            [['text_id','type'], 'integer'],
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
            'text_id' => 'Text ID',
            'img' => 'Img',
            'type' => 'Type',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getText()
    {
        return $this->hasOne(CollectingSeventeenFilesText::className(), ['id' => 'text_id']);
    }
}
