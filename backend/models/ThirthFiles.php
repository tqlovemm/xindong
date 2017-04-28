<?php

namespace backend\models;

use frontend\models\CollectingFilesImg;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "pre_collecting_files_text".
 *
 * @property integer $id
 * @property string $weichat
 * @property string $cellphone
 * @property string $weibo
 * @property string $address
 * @property integer $age
 * @property integer $vip
 * @property integer $sex
 * @property integer $height
 * @property integer $weight
 * @property integer $marry
 * @property string $job
 * @property string $hobby
 * @property string $like_type
 * @property string $car_type
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $flag
 * @property integer $status
 * @property integer $jiecao_coin
 * @property string $often_go
 * @property string $annual_salary
 * @property string $qq
 * @property string $flop_id
 * @property string $flop_id2
 * @property string $flop_id3
 *
 * @property CollectingFilesImg[] $collectingFilesImgs
 */
class ThirthFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'sex', 'height', 'weight', 'marry', 'created_at', 'updated_at', 'status','flop_id','flop_id2','flop_id3','vip','jiecao_coin'], 'integer'],
            [['cellphone','weichat', 'weibo', 'car_type', 'often_go'], 'string', 'max' => 30],
            [['address', 'job', 'annual_salary'], 'string', 'max' => 128],
            [['hobby', 'like_type'], 'string', 'max' => 256],
            [['extra'], 'string', 'max' => 512],
            [['flag'], 'string', 'max' => 32],
            [['qq'], 'string', 'max' => 11]
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
            'flop_id' => '翻牌id',
            'flop_id2' => '翻牌id2',
            'flop_id3' => '翻牌id3',
            'cellphone' => '手机号码',
            'weibo' => '微博号',
            'address' => '地址',
            'age' => '年龄',
            'sex' => '性别',
            'vip' => '会员等级',
            'height' => '身高',
            'weight' => '体重',
            'marry' => '婚否（0单身，1有女朋友，2已婚）',
            'job' => '工作职业',
            'hobby' => '兴趣爱好',
            'like_type' => '喜欢妹子类型',
            'car_type' => '车型',
            'extra' => '其他备注',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'flag' => 'Flag',
            'status' => '0未填，1审核中，2审核通过，3未通过',
            'often_go' => '常去地',
            'annual_salary' => '年薪',
            'qq' => 'QQ号码',
            'jiecao_coin' => '节操币',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCover(){

        $query = (new Query())->select('thumb_img')->from('pre_collecting_files_img')->where(['text_id'=>$this->id])->one();
        return $query['thumb_img'];

    }
    public function getImg()
    {
        return $this->hasMany(CollectingFilesImg::className(), ['text_id' => 'id']);
    }
}
