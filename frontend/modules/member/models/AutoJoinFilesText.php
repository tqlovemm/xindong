<?php

namespace frontend\modules\member\models;

use Yii;

/**
 * This is the model class for table "pre_auto_joining_files_text".
 *
 * @property integer $id
 * @property integer $link_id
 * @property string $weichat
 * @property string $cellphone
 * @property string $weibo
 * @property string $qq
 * @property string $address_province
 * @property string $address_city
 * @property string $birthday
 * @property integer $height
 * @property integer $weight
 * @property string $job
 * @property integer $is_marry
 * @property string $hobby
 * @property string $like_type
 * @property string $often_go
 * @property string $annual_salary
 * @property string $extra
 * @property integer $updated_at
 * @property integer $created_at
 *
 * @property AutoJoinFilesImg[] $autoJoiningFilesImgs
 * @property AutoJoinLink $link
 */
class AutoJoinFilesText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_auto_joining_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['weichat', 'address_province'], 'required'],
            [['link_id', 'height', 'weight', 'is_marry', 'updated_at', 'created_at'], 'integer'],
            [['weichat', 'weibo', 'address_province', 'address_city', 'annual_salary'], 'string', 'max' => 32],
            [['cellphone', 'qq', 'birthday'], 'string', 'max' => 16],
            [['job', 'hobby', 'like_type', 'often_go', 'extra'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'link_id' => 'Link ID',
            'weichat' => 'Weichat',
            'cellphone' => 'Cellphone',
            'weibo' => 'Weibo',
            'qq' => 'Qq',
            'address_province' => 'Address Province',
            'address_city' => 'Address City',
            'birthday' => 'Birthday',
            'height' => 'Height',
            'weight' => 'Weight',
            'job' => 'Job',
            'is_marry' => 'Is Marry',
            'hobby' => 'Hobby',
            'like_type' => 'Like Type',
            'often_go' => 'Often Go',
            'annual_salary' => 'Annual Salary',
            'extra' => 'Extra',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
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
            }
            return true;
        } else {
            return false;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutoJoiningFilesImgs()
    {
        return $this->hasMany(AutoJoinFilesImg::className(), ['text_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLink()
    {
        return $this->hasOne(AutoJoinLink::className(), ['id' => 'link_id']);
    }
}
