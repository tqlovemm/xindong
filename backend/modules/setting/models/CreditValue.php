<?php

namespace backend\modules\setting\models;

use Yii;

/**
 * This is the model class for table "pre_credit_value".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 * @property integer $levels
 * @property integer $viscosity
 * @property integer $lan_skills
 * @property integer $sex_skills
 * @property integer $appearance
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class CreditValue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_credit_value';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'levels', 'viscosity', 'lan_skills', 'sex_skills', 'appearance'], 'required'],
            [['user_id', 'status', 'levels', 'viscosity', 'lan_skills', 'sex_skills', 'appearance', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){

                $this->created_at = time();
                $this->updated_at = time();
            }

            return true;

        }else{

            return false;
        }

    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'status' => 'Status',
            'levels' => '会员等级',
            'viscosity' => '会员粘度',
            'lan_skills' => '语言技巧',
            'sex_skills' => '羞羞技巧',
            'appearance' => '外貌形象',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
