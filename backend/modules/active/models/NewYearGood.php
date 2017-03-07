<?php

namespace backend\modules\active\models;

use Yii;

/**
 * This is the model class for table "pre_new_year_good".
 *
 * @property integer $id
 * @property integer $da_id
 * @property string $sayGood
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property WeichatDazzle $da
 */
class NewYearGood extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_new_year_good';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['da_id', 'sayGood', 'status'], 'required'],
            [['da_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['sayGood'], 'string', 'max' => 255]
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
            'sayGood' => 'Say Good',
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
        return $this->hasOne(WeichatDazzle::className(), ['id' => 'da_id']);
    }
}
