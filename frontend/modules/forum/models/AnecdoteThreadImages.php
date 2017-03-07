<?php

namespace frontend\modules\forum\models;

use Yii;

/**
 * This is the model class for table "pre_anecdote_thread_images".
 *
 * @property integer $id
 * @property integer $tid
 * @property string $img
 * @property string $thumbimg
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AnecdoteThreads $t
 */
class AnecdoteThreadImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_anecdote_thread_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid'], 'required'],
            [['tid', 'created_at', 'updated_at'], 'integer'],
            [['img', 'thumbimg'], 'string', 'max' => 128]
        ];
    }
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
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'tid' => 'Tid',
            'img' => 'Img',
            'thumbimg' => 'Thumbimg',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
