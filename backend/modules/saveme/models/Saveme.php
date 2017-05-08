<?php

namespace backend\modules\saveme\models;

use Yii;

/**
 * This is the model class for table "pre_saveme".
 *
 * @property string $id
 * @property string $created_id
 * @property string $address
 * @property string $content
 * @property integer $price
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $end_time
 * @property integer $status
 */
class Saveme extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_saveme';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_id', 'address', 'content', 'price', 'created_at', 'updated_at', 'end_time', 'status'], 'required'],
            [['created_id', 'price', 'created_at', 'updated_at', 'end_time', 'status'], 'integer'],
            [['address', 'content'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '救我ID',
            'created_id' => '发布人ID',
            'address' => '地址',
            'content' => '内容',
            'price' => '消费节操币',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'end_time' => '到期时间',
            'status' => 'Status',
        ];
    }
}
