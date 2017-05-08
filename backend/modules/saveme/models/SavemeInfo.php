<?php

namespace backend\modules\saveme\models;

use Yii;

/**
 * This is the model class for table "pre_saveme_apply".
 *
 * @property string $id
 * @property string $saveme_id
 * @property string $apply_uid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $type
 * @property integer $status
 */
class SavemeInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_saveme_apply';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['saveme_id', 'apply_uid', 'created_at', 'updated_at', 'type', 'status'], 'required'],
            [['saveme_id', 'apply_uid', 'created_at', 'updated_at', 'type', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saveme_id' => '救我ID',
            'apply_uid' => '申请人ID',
            'created_at' => '申请时间',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }
}
