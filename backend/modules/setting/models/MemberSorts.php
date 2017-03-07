<?php

namespace backend\modules\setting\models;

use Yii;

/**
 * This is the model class for table "pre_member_sorts".
 *
 * @property integer $id
 * @property string $member_name
 * @property integer $giveaway
 * @property string $member_introduce
 * @property string $permissions
 * @property integer $price_1
 * @property integer $price_2
 * @property integer $price_3
 * @property integer $groupid
 * @property double $discount
 * @property integer $flag
 */
class MemberSorts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_member_sorts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_name', 'member_introduce','permissions', 'price_1','price_2','price_3', 'discount'], 'required'],
            [['price_1','price_2','price_3','groupid','giveaway','flag'], 'integer'],
            [['discount'], 'number'],
            [['member_name'], 'string', 'max' => 50],
            [['member_introduce','permissions'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_name' => '会员名称',
            'giveaway' => '赠送节操币',
            'member_introduce' => '会员介绍',
            'permissions' => '会员权限',
            'price_1' => '北上广深浙苏价格',
            'price_2' => '新蒙青甘藏宁琼价格',
            'price_3' => '海外及其他地区价格',
            'discount' => '折扣',
            'groupid'=>'匹配用户组',
        ];
    }
}
