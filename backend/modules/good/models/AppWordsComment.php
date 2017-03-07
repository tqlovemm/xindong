<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "pre_app_words_comment".
 *
 * @property integer $id
 * @property integer $words_id
 * @property integer $first_id
 * @property integer $second_id
 * @property string $img
 * @property string $comment
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AppWords $words
 */
class AppWordsComment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_words_comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['words_id', 'first_id', 'comment',], 'required'],
            [['words_id', 'first_id', 'second_id', 'flag', 'created_at', 'updated_at'], 'integer'],
            [['comment'], 'string'],
            [['img'], 'string', 'max' => 5000]
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
            'first_id' => 'First ID',
            'second_id' => 'Second ID',
            'img' => 'Img',
            'comment' => 'Comment',
            'flag' => 'Flag',
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
