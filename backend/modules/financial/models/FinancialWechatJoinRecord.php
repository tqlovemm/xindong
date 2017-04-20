<?php

namespace backend\modules\financial\models;

use common\Qiniu\QiniuUploader;
use Yii;

/**
 * This is the model class for table "pre_financial_wechat_join_record".
 *
 * @property integer $id
 * @property integer $wechat_id
 * @property string $join_source
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $day_time
 * @property integer $weekly_time
 * @property integer $mouth_time
 * @property string $channel
 * @property integer $payment_amount
 * @property integer $payment_to
 * @property integer $vip
 * @property string $join_address
 * @property string $remarks
 * @property string $payment_screenshot
 * @property string $platform
 * @property string $number
 * @property integer $type
 */
class FinancialWechatJoinRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_financial_wechat_join_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['payment_amount','wechat_id','payment_to'], 'required','message'=>"{attribute}不可为空"],
            [['wechat_id', 'created_at', 'updated_at', 'created_by', 'payment_amount', 'vip', 'type','day_time','weekly_time','mouth_time','payment_to'], 'integer'],
            [['join_source', 'channel', 'join_address','platform','number'], 'string', 'max' => 128],
            [['remarks','payment_screenshot'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wechat_id' => '客服微信号',
            'join_source' => '入会来源',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'weekly_time' => '每周时间',
            'mouth_time' => '每月时间',
            'day_time' => '每日时间',
            'created_by' => '创建人',
            'channel' => '付款渠道',
            'payment_amount' => '付款金额',
            'vip' => '入会等级',
            'join_address' => '入会地址',
            'remarks' => '备注',
            'type' => '付款类型',
            'payment_screenshot' => '付款截图',
            'platform' => '入会平台',
            'number' => '会员编号',
            'payment_to' => '付款到哪',
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
                $this->day_time = strtotime('today');
                $this->weekly_time = strtotime('next sunday');
                $this->mouth_time = mktime(23,59,59,date('m'),date('t')-1,date('Y'))+1;
                $this->created_by = Yii::$app->user->id;
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

    public function getWechat()
    {
        return $this->hasOne(FinancialWechat::className(), ['id' => 'wechat_id']);
    }

    public function upload()
    {
        if ($this->validate()) {
            $filepath = $_FILES['FinancialWechatJoinRecord']['tmp_name']['payment_screenshot'];
            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->wechat_id.'_'.uniqid();
            $qiniu = $qn->upload_app('test',"uploads/payment_change/$mkdir",$filepath);
            return $qiniu['key'];
        } else {
            return false;
        }
    }

}
