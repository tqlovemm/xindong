<?php

namespace backend\modules\local\models;

use Yii;

/**
 * This is the model class for table "pre_local_collection_count".
 *
 * @property integer $id
 * @property integer $count
 * @property string $type
 * @property integer $number
 * @property string $number_name
 * @property string $name
 */
class LocalCollectionCount extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_local_collection_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['count', 'type'], 'required'],
            [['count','number'], 'integer'],
            [['type','number_name','name'], 'string']
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
            'number' => 'Number',
            'name' => 'Name',
            'number_name' => 'Number Name',
        ];
    }
}
