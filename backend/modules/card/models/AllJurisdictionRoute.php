<?php

namespace backend\modules\card\models;

use backend\models\User;
use Yii;

/**
 * This is the model class for table "{{%z_user_all_jurisdiction_route}}".
 *
 * @property string $route
 * @property string $description
 * @property integer $type
 * @property integer $created_at
 *
 * @property AllJurisdictionRouteChild[] $zUserAllJurisdictionRouteChildren
 * @property AllJurisdictionRouteChild[] $zUserAllJurisdictionRouteChildren0
 * @property JurisdictionAssignment[] $zUserJurisdictionAssignments
 * @property User[] $users
 */
class AllJurisdictionRoute extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%z_user_all_jurisdiction_route}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['route'], 'required'],
            [['type', 'created_at'], 'integer'],
            [['route'], 'string', 'max' => 128],
            [['description'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'route' => 'Route',
            'description' => 'Description',
            'type' => 'Type',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren()
    {
        return $this->hasMany(AllJurisdictionRouteChild::className(), ['parent' => 'route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChildren0()
    {
        return $this->hasMany(AllJurisdictionRouteChild::className(), ['child' => 'route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAssignments()
    {
        return $this->hasMany(JurisdictionAssignment::className(), ['item_name' => 'route']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id'])->viaTable('{{%z_user_jurisdiction_assignment}}', ['item_name' => 'route']);
    }
}
