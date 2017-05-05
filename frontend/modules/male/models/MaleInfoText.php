<?php

namespace frontend\modules\male\models;

use Yii;

/**
 * This is the model class for table "pre_male_info_text".
 *
 * @property integer $id
 * @property string $wechat
 * @property string $cellphone
 * @property string $email
 * @property integer $age
 * @property string $car_type
 * @property string $annual_salary
 * @property integer $height
 * @property integer $weight
 * @property integer $marry
 * @property string $job
 * @property string $offten_go
 * @property string $hobby
 * @property string $like_type
 * @property string $remarks
 * @property integer $coin
 * @property string $province
 * @property string $city
 * @property integer $vip
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $flag
 * @property integer $status
 * @property integer $created_by
 * @property integer $handler
 * @property string $no_pass_reason
 */
class MaleInfoText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_male_info_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'height', 'weight', 'marry', 'coin', 'vip', 'created_at', 'updated_at', 'status', 'created_by', 'handler'], 'integer'],
            [['age', 'height', 'weight','wechat', 'email', 'cellphone'], 'required'],
            [['wechat', 'email', 'car_type', 'annual_salary', 'province', 'city', 'flag'], 'string', 'max' => 32],
            [['cellphone'], 'string', 'max' => 11],
            [['job', 'offten_go', 'hobby', 'like_type', 'remarks', 'no_pass_reason'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '会员编号',
            'wechat' => '微信号',
            'cellphone' => '手机号',
            'email' => '邮箱',
            'age' => '年龄',
            'car_type' => '私家车类型',
            'annual_salary' => '年薪',
            'height' => '身高',
            'weight' => '体重',
            'marry' => '婚姻情况',
            'job' => '工作职业',
            'offten_go' => '常去地',
            'hobby' => '兴趣爱好',
            'like_type' => '喜欢妹子类型',
            'remarks' => '备注',
            'coin' => '初始节操币',
            'province' => '入会省份',
            'city' => '入会城市',
            'vip' => '等级',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'flag' => 'Flag',
            'status' => '审核状态',
            'created_by' => '创建人',
            'handler' => '审核人',
            'no_pass_reason' => '不通过原因',
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_by = Yii::$app->user->id;
                $this->created_at = time();
                $this->updated_at = time();
                $this->flag = uniqid();
                $this->status = 0;
            }else{
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function getWm()
    {
        return $this->hasOne(MaleInfoImages::className(), ['text_id' => 'id'])->where(['type'=>2]);
    }

    public function getAvatar()
    {
        return $this->hasOne(MaleInfoImages::className(), ['text_id' => 'id'])->where(['type'=>1])->asArray();
    }

    public function getImg()
    {
        return $this->hasMany(MaleInfoImages::className(), ['text_id' => 'id'])->where(['type'=>[0,1]]);
    }
}
