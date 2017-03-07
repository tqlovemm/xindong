<?php

namespace backend\modules\active\models;

use Yii;

/**
 * This is the model class for table "pre_new_year_img".
 *
 * @property integer $id
 * @property integer $da_id
 * @property string $path
 * @property string $thumb
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property WeichatDazzle $da
 */
class NewYearImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_new_year_img';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['da_id', 'path', 'thumb', 'status'], 'required'],
            [['da_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['path', 'thumb'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'da_id' => 'Da ID',
            'path' => 'Path',
            'thumb' => 'Thumb',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDa()
    {
        return $this->hasOne(NewYear::className(), ['id' => 'da_id']);
    }
}
