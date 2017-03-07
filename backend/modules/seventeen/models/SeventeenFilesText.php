<?php

namespace backend\modules\seventeen\models;

use Yii;

/**
 * This is the model class for table "pre_collecting_17_files_text".
 *
 * @property integer $id
 * @property string $weichat
 * @property string $cellphone
 * @property string $address_province
 * @property string $address_city
 * @property string $address_detail
 * @property string $education
 * @property integer $age
 * @property integer $sex
 * @property integer $height
 * @property integer $weight
 * @property string $cup
 * @property string $job
 * @property string $job_detail
 * @property integer $gotofield
 * @property string $weibo
 * @property string $id_number
 * @property integer $pay
 * @property integer $qq
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $flag
 * @property integer $status
 *
 * @property Collecting17FilesImg[] $collecting17FilesImgs
 */
class SeventeenFilesText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_17_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weichat', 'address_province', 'address_city', 'address_detail', 'age', 'height', 'weight', 'cup', 'job', 'job_detail', 'gotofield', 'weibo', 'id_number', 'pay', 'qq', 'extra', 'created_at', 'updated_at', 'flag', 'status'], 'required'],
            [['age', 'sex', 'height', 'weight', 'gotofield', 'pay', 'qq', 'created_at', 'updated_at', 'status'], 'integer'],
            [['weichat'], 'string', 'max' => 30],
            [['cellphone', 'id_number'], 'string', 'max' => 20],
            [['address_province', 'address_city', 'job'], 'string', 'max' => 128],
            [['address_detail', 'job_detail', 'extra'], 'string', 'max' => 512],
            [['education'], 'string', 'max' => 125],
            [['cup', 'weibo'], 'string', 'max' => 50],
            [['flag'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '会员编号',
            'weichat' => '微信号',
            'cellphone' => '手机号',
            'address_province' => '省份',
            'address_city' => '城市',
            'address_detail' => '地区详情',
            'education' => '学历',
            'age' => '生日',
            'sex' => '性别',
            'height' => '身高',
            'weight' => '体重',
            'cup' => '罩杯',
            'job' => '职业',
            'job_detail' => '工作详情',
            'gotofield' => 'Gotofield',
            'weibo' => '微博号',
            'id_number' => '身份证号码',
            'pay' => '每月费用',
            'qq' => 'Qq号',
            'extra' => '其他备注',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'status' => '填写情况，0未填写，1填写一张表，2填写两张表',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollecting17FilesImgs()
    {
        return $this->hasMany(Collecting17FilesImg::className(), ['text_id' => 'id']);
    }
}
