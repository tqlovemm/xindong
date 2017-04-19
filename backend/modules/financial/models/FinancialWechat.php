<?php

namespace backend\modules\financial\models;

use Yii;

/**
 * This is the model class for table "pre_financial_wechat".
 *
 * @property integer $id
 * @property string $wechat
 * @property string $remarks
 * @property integer $member_count
 * @property double $loose_change
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $status
 */
class FinancialWechat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_financial_wechat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wechat','member_count',], 'required','message'=>"{attribute}不可为空"],
            [['wechat'], 'unique'],
            [['member_count', 'created_at', 'updated_at', 'created_by', 'status'], 'integer'],
            [['loose_change'], 'number'],
            [['wechat'], 'string', 'max' => 128],
            [['remarks'], 'string', 'max' => 256]
        ];
    }

    public function unique(){


        if(!empty(self::findOne(['wechat'=>$this->wechat]))){

            $this->addError('wechat','微信号不可重复');
        }

    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wechat' => '客服微信号',
            'remarks' => '备注说明',
            'member_count' => '现有好友人数',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'created_by' => '创建人',
            'status' => '是否可见',
            'loose_change' => '创建时零钱数',
        ];
    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
                $this->created_by = Yii::$app->user->id;
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }


    public function getJoinRecord()
    {
        return $this->hasMany(FinancialWechatJoinRecord::className(), ['wechat_id' => 'id']);
    }


    public function getMemberIncrease()
    {
        return $this->hasMany(FinancialWechatMemberIncrease::className(), ['wechat_id' => 'id']);
    }

}
