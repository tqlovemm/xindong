<?php

namespace backend\modules\male\models;

use Yii;

/**
 * This is the model class for table "pre_male_info_text".
 *
 * @property integer $id
 * @property integer $coin
 * @property string $province
 * @property string $city
 * @property integer $vip
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $flag
 * @property integer $status
 * @property integer $created_by
 */
class MaleInfoText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_male_info_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'coin', 'vip', 'created_at', 'updated_at', 'status', 'created_by'], 'integer'],
            [['coin', 'province', 'vip'], 'required'],
            [[ 'province', 'city', 'flag'], 'string', 'max' => 64],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'coin' => 'Coin',
            'province' => 'Province',
            'city' => 'City',
            'vip' => 'Vip',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'status' => 'Status',
            'created_by' => 'Created By',
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
                $this->created_by = Yii::$app->user->id;
                $this->created_at = time();
                $this->updated_at = time();
                $this->flag = Yii::$app->params['hostname'].'/'.uniqid();
                $this->status = 0;
            }else{
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
