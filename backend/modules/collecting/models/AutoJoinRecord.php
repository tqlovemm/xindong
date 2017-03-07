<?php

namespace backend\modules\collecting\models;

use Yii;

/**
 * This is the model class for table "pre_auto_joining_record".
 *
 * @property integer $id
 * @property integer $member_sort
 * @property integer $member_area
 * @property integer $recharge_type
 * @property string $cellphone
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $extra
 * @property integer $status
 * @property string $origin
 * @property integer $price
 */
class AutoJoinRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_auto_joining_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_sort', 'member_area', 'recharge_type', 'cellphone', 'created_at', 'updated_at', 'status'], 'required'],
            [['member_sort', 'member_area', 'recharge_type', 'created_at', 'updated_at', 'status','price'], 'integer'],
            [['cellphone'], 'string', 'max' => 20],
            [['origin'], 'string', 'max' => 64],
            [['extra'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_sort' => 'Member Sort',
            'member_area' => 'Member Area',
            'recharge_type' => 'Recharge Type',
            'cellphone' => 'Cellphone',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'extra' => 'Extra',
            'status' => 'Status',
            'origin' => 'Origin',
            'price' => 'Price',
        ];
    }
}
