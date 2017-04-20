<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_saveme_apply".
 *
 * @property string $id
 * @property string $saveme_id
 * @property string $apply_uid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class SavemeInfo extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%saveme_apply}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['saveme_id', 'apply_uid', 'status'], 'required'],
            [['saveme_id', 'apply_uid', 'created_at', 'updated_at', 'status', 'type'], 'integer']
        ];
    }

    public function fields(){

        return [
            'apply_id'=>'id','saveme_id', 'apply_uid', 'created_at','updated_at', 'status',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saveme_id' => 'Saveme ID',
            'apply_uid' => '申请人id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }
}
