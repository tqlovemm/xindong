<?php

namespace backend\modules\collecting\models;

use yii\db\Query;

/**
 * This is the model class for table "pre_app_collecting_files_text".
 *
 * @property integer $id
 * @property string $weichat
 * @property string $cellphone
 * @property string $weibo
 * @property string $address
 * @property integer $age
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
 * @property string $often_go
 * @property string $annual_salary
 * @property string $qq
 * @property string $flop_id
 *
 * @property AppFilesImg[] $appFilesImgs
 */
class AppFiles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_collecting_files_text';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['age', 'sex', 'height', 'weight', 'marry', 'created_at', 'updated_at', 'status','flop_id'], 'integer'],
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
            'cellphone' => '手机号码',
            'weibo' => '微博号',
            'address' => '地址',
            'age' => '年龄',
            'sex' => '性别',
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
            'status' => '0未填写，1已填等待审核中，2审核通过，3未通过修改中',
            'often_go' => '常去地',
            'annual_salary' => '年薪',
            'qq' => 'QQ号码',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */

    public function getCover(){

        $query = (new Query())->select('img')->from('pre_app_collecting_files_img')->where(['text_id'=>$this->id])->one();
        return $query['img'];

    }
    public function getAppFilesImgs()
    {
        return $this->hasMany(AppFilesImg::className(), ['text_id' => 'id']);
    }
}
