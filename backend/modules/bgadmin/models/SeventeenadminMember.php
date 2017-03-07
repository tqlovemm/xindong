<?php

namespace backend\modules\bgadmin\models;

use backend\components\Uploader;
use Yii;

/**
 * This is the model class for table "pre_17admin_member".
 *
 * @property integer $member_id
 * @property string $number
 * @property string $weicaht
 * @property string $weibo
 * @property string $cellphone
 * @property string $address_a
 * @property string $address_b
 * @property integer $sex
 * @property integer $vip
 * @property integer $status
 * @property string $time
 * @property string $updated_at
 * @property string $created_at
 * @property string $created_by
 *
 * @property SeventeenadminMemberText $memberText
 */
class SeventeenadminMember extends \yii\db\ActiveRecord
{
    public $record_type;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_17admin_member';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number','sex'], 'required'],
            [['number'], 'validateExe'],
            [['sex', 'vip', 'status', 'record_type'], 'integer'],
            [['number', 'cellphone', 'created_by'], 'string', 'max' => 16],
            [['weicaht', 'weibo', 'address_a'], 'string', 'max' => 32],
            [['address_b'], 'string', 'max' => 128],
            [['time', 'updated_at', 'created_at'], 'string', 'max' => 11]
        ];
    }

    public function validateExe()
    {
        $member = SeventeenadminMember::findOne(['number'=>$this->number]);
        if($this->isNewRecord) {
            if (!empty($member)) {
                $this->addError('number', '会员编号已经存在');
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
            'time' => '入会时间',
            'updated_at' => '更新时间',
            'created_at' => '创建时间',
            'created_by' => '创建人',
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
                $this->created_by = Yii::$app->user->identity->username;

            }else{

                $this->updated_at = time();
            }

            return true;
        }

        return false;
    }



    public function getMemberText($type)
    {
        return $this->hasMany(SeventeenadminMemberText::className(), ['member_id' => 'member_id'])->joinWith('memberFiles')->where(['type'=>$type])->orderBy('pre_smadmin_member_text.created_at desc');
    }

}
