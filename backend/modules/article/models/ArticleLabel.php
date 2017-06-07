<?php

namespace backend\modules\article\models;

use Yii;

/**
 * This is the model class for table "pre_article_label".
 *
 * @property integer $lid
 * @property string $labelname
 * @property string $thumb
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class ArticleLabel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_article_label';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['labelname', 'thumb'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['labelname'], 'string', 'max' => 50],
            [['thumb'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'lid' => 'Lid',
            'labelname' => '标签名',
            'thumb' => '图片',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
            'status' => 'Status',
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
