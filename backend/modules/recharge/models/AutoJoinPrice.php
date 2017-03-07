<?php

namespace backend\modules\recharge\models;

use Yii;

/**
 * This is the model class for table "pre_auto_joining_price".
 *
 * @property integer $id
 * @property integer $member_sort
 * @property integer $member_area
 * @property integer $recharge_type
 * @property string $type_content
 * @property integer $price
 * @property integer $status
 */
class AutoJoinPrice extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_auto_joining_price';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_sort', 'member_area', 'recharge_type', 'price'], 'required'],
            [['member_sort', 'member_area', 'recharge_type', 'price', 'status'], 'integer'],
            [['type_content'], 'string'],
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
            'type_content' => '套餐内容描述(非套餐可不填)',
            'price' => 'Price',
            'status' => 'Status',
        ];
    }
}
