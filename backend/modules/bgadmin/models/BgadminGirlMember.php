<?php

namespace backend\modules\bgadmin\models;

use backend\components\Uploader;
use Yii;

/**
 * This is the model class for table "pre_bgadmin_girl_member".
 *
 * @property integer $member_id
 * @property string $number
 * @property integer $age
 * @property integer $height
 * @property integer $weight
 * @property string $cup
 * @property string $job
 * @property string $hobby
 * @property string $like_type
 * @property string $weicaht
 * @property string $weibo
 * @property string $cellphone
 * @property string $address_a
 * @property string $address_b
 * @property integer $sex
 * @property integer $vip
 * @property integer $status
 * @property integer $coin
 * @property string $time
 * @property string $updated_at
 * @property string $created_at
 * @property string $created_by
 * @property string $fantasies
 * @property string $credit
 * @property string $flag
 * @property integer $foreign
 *
 * @property BgadminGirlMemberText $memberGirlText
 */
class BgadminGirlMember extends \yii\db\ActiveRecord
{
    public $record_type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_bgadmin_girl_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sex','address_a'], 'required'],
            [['sex', 'vip', 'status', 'record_type', 'coin','age','height','weight','foreign'], 'integer'],
            [['cellphone'], 'string', 'max' => 64],
            [['weicaht', 'weibo', 'address_a', 'flag', 'cup', 'job', 'hobby', 'like_type'], 'string', 'max' => 32],
            [['address_b'], 'string', 'max' => 128],
            [['time', 'updated_at', 'created_at','fantasies','credit'], 'string', 'max' => 11],
            [['number','fantasies','credit'],'validateFCN'],
            [['number', 'created_by'], 'string', 'max' => 16],
            [['fantasies', 'credit'], 'string'],
        ];
    }

    public function validateFCN()
    {
        if($this->sex ==1){
            if(empty($this->fantasies)){
                $this->addError('fantasies', '女生颜值不可为空');
            }
            if(empty($this->credit)){
                $this->addError('credit', '女生信用度不可为空');
            }
        }elseif($this->sex ==0){
            $member = BgadminGirlMember::findOne(['number'=>$this->number]);
            if($this->isNewRecord) {
                if (!empty($member)) {
                    $this->addError('number', '会员编号已经存在');
                }
            }
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'member_id' => 'Member ID',
            'number' => '会员编号',
            'weicaht' => '微信号',
            'weibo' => '微博号',
            'cellphone' => '手机号',
            'address_a' => '主地址',
            'address_b' => '其他地址',
            'sex' => '性别',
            'vip' => '会员等级',
            'status' => 'Status',
            'coin' => '节操币',
            'time' => '入会时间',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
            'created_by' => '创建人',
            'fantasies' => '颜值',
            'credit' => '信用度',
            'flag' => '标记',
            'cup' => '罩杯',
            'job' => '工作',
            'hobby' => '兴趣爱好',
            'like_type' => '喜欢类型',
            'age' => '年龄',
            'height' => '身高',
            'weight' => '体重',
            'foreign' => '是否保密',
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
                $this->time = date('Y-m-d',time());
                $this->created_by = !empty(Yii::$app->user->identity->username)?Yii::$app->user->identity->username:"会员自填";

            }else{

                $this->updated_at = time();
            }

            return true;
        }

        return false;
    }



    public function getMemberText($type)
    {
        return $this->hasMany(BgadminGirlMemberText::className(), ['member_id' => 'member_id'])->joinWith('memberFiles')->where(['type'=>$type])->orderBy('pre_bgadmin_girl_member_text.created_at desc');
    }
    public function getFile(){

        return $this->hasMany(BgadminGirlMemberFiles::className(), ['member_id' => 'member_id'])->joinWith('memberFiles')->where(['type'=>0]);

    }

    public function getFile2(){

        return $this->hasMany(BgadminGirlMemberFiles::className(), ['member_id' => 'member_id'])->where(['img_type'=>0]);

    }

}
