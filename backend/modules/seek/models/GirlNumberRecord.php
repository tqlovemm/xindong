<?php

namespace backend\modules\seek\models;

use Yii;

/**
 * This is the model class for table "pre_girl_number_record".
 *
 * @property integer $id
 * @property string $number
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $created_by
 */
class GirlNumberRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_girl_number_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at'], 'integer'],
            [['number', 'created_by'], 'string', 'max' => 16]
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = strtotime('today');
                $this->created_by = Yii::$app->user->identity->username;
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
        ];
    }
}
