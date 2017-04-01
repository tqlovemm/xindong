<?php

namespace backend\modules\setting\models;

use Yii;

/**
 * This is the model class for table "pre_predefined_jiecao_coin".
 *
 * @property integer $id
 * @property number $money
 * @property integer $giveaway
 * @property integer $status
 * @property integer $type
 * @property integer $member_type
 * @property integer $is_activity
 */
class PredefinedJiecaoCoin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_predefined_jiecao_coin';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['giveaway','money','type'], 'required'],
            [['giveaway', 'status','type','member_type','is_activity'], 'integer'],
            [['money'],'number']
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){

            if($this->isNewRecord){

                $this->status = 10;
            }

            return true;
        }

        return false;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'money' => '充值金额',
            'giveaway' => '赠送金额',
            'status' => '状态',
            'type' => '平台',
            'member_type' => '会员等级',
            'is_activity' => '活动充值',
        ];
    }
}
