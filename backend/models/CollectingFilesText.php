<?php

namespace backend\models;

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
class CollectingFilesText extends \yii\db\ActiveRecord
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
            'address_province2' => '省份2',
            'address_city2' => '城市2',
            'address_province3' => '省份3',
            'address_city3' => '城市3',
            'address_detail' => '地址详情',
            'education' => '学历',
            'age' => '生日',
            'sex' => '性别',
            'height' => '身高',
            'weight' => '体重',
            'cup' => '罩杯',
            'job' => '职业',
            'job_detail' => '职业详情',
            'gotofield' => 'Gotofield',
            'weibo' => '微博账号',
            'id_number' => '身份证号',
            'pay' => '月资助费',
            'qq' => 'QQ号',
            'extra' => '备注',
            'created_at' => '链接生成时间',
            'updated_at' => '更新时间',
            'flag' => 'Flag',
            'status' => '填写进度',
            'already_pa' => '啪过几个',

        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCollecting17FilesImgs()
    {
        return $this->hasMany(CollectingFilesImg::className(), ['text_id' => 'id']);
    }
}
