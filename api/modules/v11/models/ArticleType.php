<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_article_type".
 *
 * @property integer $tid
 * @property string $typename
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class ArticleType extends ActiveRecord
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
            [['typename', 'created_at', 'updated_at', 'status'], 'required'],
            [['created_at', 'updated_at', 'status'], 'integer'],
            [['typename'], 'string', 'max' => 100]
        ];
    }

    public function fields(){
        return [
            'tid','typename',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => 'Tid',
            'typename' => 'Typename',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
