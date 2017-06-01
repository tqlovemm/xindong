<?php

namespace backend\modules\article\models;

use Yii;

/**
 * This is the model class for table "pre_article_adver".
 *
 * @property integer $id
 * @property string $thumb
 * @property integer $created_id
 * @property string $url
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class ArticleAdver extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_article_adver';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thumb', 'url'], 'required'],
            [['created_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['thumb', 'url'], 'string', 'max' => 500]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumb' => '广告图',
            'created_id' => '创建人',
            'url' => '广告图链接',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_id = Yii::$app->user->id;
                $this->status = 1;
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
