<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_user_avatar_check".
 *
 * @property integer $user_id
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $file
 *
 * @property User $user
 */
class UserAvatarCheck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_avatar_check';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['file'], 'string', 'max' => 250],
            [['user_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){

                $this->user_id = Yii::$app->user->id;
                $this->created_at = time();

            }

            $this->updated_at = time();


            return true;

        }
        return false;
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'file' => 'File',
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
