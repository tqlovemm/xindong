<?php

namespace backend\modules\financial\models;

use common\Qiniu\QiniuUploader;
use Yii;

/**
 * This is the model class for table "pre_financial_wechat_member_increase".
 *
 * @property integer $id
 * @property integer $wechat_id
 * @property integer $increase_count
 * @property integer $morning_increase_count
 * @property integer $total_count
 * @property integer $reduce_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property double $loose_change
 * @property integer $join_count
 * @property integer $day_time
 * @property integer $weekly_time
 * @property integer $mouth_time
 * @property integer $year_time
 * @property string $remarks
 * @property string $wechat_loose_change_screenshot
 */
class FinancialWechatMemberIncrease extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_financial_wechat_member_increase';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['wechat_id','total_count'], 'required','message'=>"{attribute}不可为空"],
            [['wechat_id'], 'unique'],
            [['wechat_id', 'increase_count','morning_increase_count','year_time','total_count', 'reduce_count', 'created_at', 'updated_at', 'created_by', 'join_count','day_time','weekly_time','mouth_time'], 'integer'],
            [['loose_change'], 'number'],
            [['remarks','wechat_loose_change_screenshot'], 'string'],
        ];
    }

    public function unique(){

        if(!empty(self::findOne(['wechat_id'=>$this->wechat_id,'day_time'=>strtotime('yesterday')]))){
            $this->addError("morning_increase_count","今日已经记录人数");
        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'wechat_id' => '客服微信号',
            'increase_count' => '今日增加人数',
            'morning_increase_count' => '早晨增加未通过人数',
            'total_count' => '今日总人数',
            'reduce_count' => '今日删除人数',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'weekly_time' => '每周时间',
            'mouth_time' => '每月时间',
            'year_time' => '每年时间',
            'day_time' => '每日时间',
            'created_by' => '创建人',
            'loose_change' => '今日微信零钱数',
            'join_count' => '今日入会人数',
            'remarks' => '备注',
            'wechat_loose_change_screenshot' => '今日微信零钱数截图',
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
                $this->day_time = strtotime('yesterday');
                $this->weekly_time = strtotime('next sunday');
                $this->mouth_time =mktime(0,0,0,date('m',time()),date('t'),date('Y',time()));
                $this->year_time = mktime(0,0,0,12,31,date('Y',time()));
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
            $filepath = $_FILES['FinancialWechatMemberIncrease']['tmp_name']['wechat_loose_change_screenshot'];
            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->wechat_id.'_'.uniqid();
            $qiniu = $qn->upload_app('test02',"uploads/wechat_loose_change/$mkdir",$filepath);
            return $qiniu['key'];
        } else {
            return false;
        }
    }

}
