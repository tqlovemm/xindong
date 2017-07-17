<?php

namespace backend\modules\card\models;

use Yii;

/**
 * This is the model class for table "{{%z_user_all_jurisdiction_route_child}}".
 *
 * @property string $parent
 * @property string $child
 *
 * @property AllJurisdictionRoute $parent0
 * @property AllJurisdictionRoute $child0
 */
class AllJurisdictionRouteChild extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%z_user_all_jurisdiction_route_child}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent', 'child'], 'required'],
            [['parent', 'child'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'parent' => 'Parent',
            'child' => 'Child',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent0()
    {
        return $this->hasOne(AllJurisdictionRoute::className(), ['route' => 'parent']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChild0()
    {
        return $this->hasOne(AllJurisdictionRoute::className(), ['route' => 'child']);
    }
}
