<?php

namespace backend\modules\collecting\models;

/**
 * This is the model class for table "pre_app_collecting_files_img".
 *
 * @property integer $id
 * @property integer $text_id
 * @property string $img
 *
 * @property AppFiles $text
 */
class AppFilesImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_collecting_files_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'img'], 'required'],
            [['text_id'], 'integer'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getText()
    {
        return $this->hasOne(AppFiles::className(), ['id' => 'text_id']);
    }
}
