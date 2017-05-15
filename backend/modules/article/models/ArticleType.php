<?php

namespace backend\modules\article\models;

use Yii;

/**
 * This is the model class for table "pre_article_type".
 *
 * @property integer $tid
 * @property string $typename
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class ArticleType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_article_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['typename',], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['typename'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => 'Tid',
            'typename' => '分类名称',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
            'status' => '状态',
        ];
    }
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
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
