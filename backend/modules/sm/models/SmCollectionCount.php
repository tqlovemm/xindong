<?php

namespace backend\modules\sm\models;

use Yii;

/**
 * This is the model class for table "pre_sm_collection_count".
 *
 * @property integer $id
 * @property integer $count
 * @property integer $type
 * @property string $name
 * @property string $pre
 */
class SmCollectionCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_sm_collection_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'type'], 'required'],
            [['name','pre'], 'string'],
            [['count', 'type'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'count' => 'Count',
            'type' => 'Type',
            'name' => 'Name',
            'pre' => 'Pre',
        ];
    }
}
