<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "pre_app_words_like".
 *
 * @property integer $id
 * @property integer $words_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AppWords $words
 */
class AppWordsLike extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_words_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['words_id', 'user_id'], 'required'],
            [['words_id', 'user_id', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'words_id' => 'Words ID',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWords()
    {
        return $this->hasOne(AppWords::className(), ['id' => 'words_id']);
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){

            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }
}
