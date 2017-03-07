<?php

namespace frontend\modules\member\models;

use Yii;

/**
 * This is the model class for table "pre_auto_joining_files_img".
 *
 * @property integer $id
 * @property integer $text_id
 * @property string $img
 * @property integer $type
 *
 * @property AutoJoinFilesText $text
 */
class AutoJoinFilesImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_auto_joining_files_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'type'], 'required'],
            [['text_id', 'type'], 'integer'],
            [['img'], 'string', 'max' => 64]
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
        return $this->hasOne(AutoJoinFilesText::className(), ['id' => 'text_id']);
    }
}
