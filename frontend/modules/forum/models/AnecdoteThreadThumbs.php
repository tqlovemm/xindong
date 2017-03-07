<?php

namespace frontend\modules\forum\models;

use Yii;

/**
 * This is the model class for table "pre_anecdote_thread_thumbs".
 *
 * @property integer $thumbs_id
 * @property integer $tid
 * @property string $user_id
 * @property integer $type
 * @property integer $where
 *
 * @property AnecdoteThreads $t
 */
class AnecdoteThreadThumbs extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_anecdote_thread_thumbs';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'user_id', 'type'], 'required'],
            [['tid', 'type', 'where'], 'integer'],
            [['user_id'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thumbs_id' => 'Thumbs ID',
            'tid' => 'Tid',
            'user_id' => 'User ID',
            'type' => 'Type',
            'where' => 'Where',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getT()
    {
        return $this->hasOne(AnecdoteThreads::className(), ['tid' => 'tid']);
    }
}
