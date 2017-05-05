<?php

namespace frontend\modules\male\models;

use Yii;

/**
 * This is the model class for table "pre_male_info_images".
 *
 * @property integer $id
 * @property integer $text_id
 * @property integer $clent_id
 * @property string $img
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 */
class MaleInfoImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_male_info_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['text_id', 'img'], 'required'],
            [['text_id', 'type', 'created_at', 'updated_at'], 'integer'],
            [['img'], 'string', 'max' => 256],
            [['clent_id'], 'string', 'max' => 32],
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
            'clent_id' => 'Clent Id',
            'img' => 'Img',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
