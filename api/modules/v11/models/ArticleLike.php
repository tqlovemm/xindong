<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_article_like".
 *
 * @property integer $id
 * @property string $aid
 * @property string $userid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class ArticleLike extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_article_like';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aid', 'userid','status'], 'required'],
            [['aid', 'userid', 'created_at', 'updated_at', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'aid' => 'Aid',
            'userid' => 'Userid',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
