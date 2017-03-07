<?php

namespace frontend\modules\weixin\models;

use frontend\models\UserProfile;
use Yii;
use backend\modules\bgadmin\models\BgadminMember;

/**
 * This is the model class for table "pre_signup_before".
 *
 * @property string $invite_code
 * @property string $number
 * @property string $address
 * @property integer $coin
 * @property integer $groupid
 * @property integer $status
 */
class SignupBefore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_signup_before';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['invite_code', 'number', 'address'], 'required'],
            [['coin','groupid','status'], 'integer'],
            [['number'], 'validateExe'],
            [['invite_code', 'address'], 'string', 'max' => 16],
            [['number'], 'string', 'max' => 10]
        ];
    }

    public function validateExe()
    {
        $prifile = UserProfile::findOne(['number'=>$this->number]);
        $member = BgadminMember::findOne(['number'=>$this->number]);
        if($this->isNewRecord) {
            if (empty($member)) {
                $this->addError('number', '该会员编号不存在，如有疑问请咨询客服查询');
            }elseif(!empty($prifile)){
                $this->addError('number', '您已注册为网站会员，无需获取邀请码');
            }else{
                if(!empty(self::findOne(['number'=>$this->number]))){
                    $this->addError('number', '该编号已经被人绑定，如有疑问请咨询客服查询');
                }elseif($member->address_a!=$this->address){
                    $this->addError('address', '与入会填写地址不符合，如有疑问请咨询客服查询');
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
            'invite_code' => 'Invite Code',
            'number' => 'Number',
            'address' => 'Address',
            'coin' => 'Coin',
            'groupid' => 'Groupid',
            'status' => 'Status',
        ];
    }
}
