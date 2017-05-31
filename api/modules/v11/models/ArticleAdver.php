<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

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
class ArticleAdver extends ActiveRecord
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
            [['thumb', 'created_id', 'url'], 'required'],
            [['created_id', 'created_at', 'updated_at', 'status'], 'integer'],
            [['thumb', 'url'], 'string', 'max' => 500]
        ];
    }

    public function fields(){
        return [
            'adver_id'=>'id','thumb','created_id','url',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thumb' => 'Thumb',
            'created_id' => 'Created ID',
            'url' => 'Url',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
