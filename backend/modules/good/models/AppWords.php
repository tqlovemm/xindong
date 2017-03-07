<?php

namespace backend\modules\good\models;

use Yii;

/**
 * This is the model class for table "pre_app_words".
 *
 * @property integer $id
 * @property string $content
 * @property integer $user_id
 * @property string $address
 * @property string $img
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flag
 * @property integer $status
 *
 * @property AppAccusation[] $appAccusations
 * @property AppMessage[] $appMessages
 * @property User $user
 * @property AppWordsComment[] $appWordsComments
 * @property AppWordsLike[] $appWordsLikes
 */
class AppWords extends \yii\db\ActiveRecord
{
    public $username;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_words';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'img',], 'required'],
            [['content'], 'string'],
            [['user_id', 'created_at', 'updated_at', 'flag', 'status'], 'integer'],
            [['address','username'], 'string', 'max' => 150],
            [['img'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'content' => 'Content',
            'username' => 'Username',
            'user_id' => 'User ID',
            'address' => 'Address',
            'img' => 'Img',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppAccusations()
    {
        return $this->hasMany(AppAccusation::className(), ['words_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppMessages()
    {
        return $this->hasMany(AppMessage::className(), ['words_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppWordsComments()
    {
        return $this->hasMany(AppWordsComment::className(), ['words_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppWordsLikes()
    {
        return $this->hasMany(AppWordsLike::className(), ['words_id' => 'id']);
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
