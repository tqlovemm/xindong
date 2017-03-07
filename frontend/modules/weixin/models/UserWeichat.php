<?php

namespace frontend\modules\weixin\models;

use backend\models\User;
use backend\modules\bgadmin\models\BgadminMember;
use common\components\SaveToLog;
use Yii;

/**
 * This is the model class for table "pre_user_weichat".
 *
 * @property string $openid
 * @property string $number
 * @property string $nickname
 * @property string $headimgurl
 * @property string $address
 * @property integer $created_at
 */
class UserWeichat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_weichat';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number','address'], 'required','message'=>'不可为空'],
            [['openid'], 'string', 'max' => 64],
            [['created_at'], 'integer'],
            [['number'], 'string', 'max' => 16],
            [['number'], 'validateExe'],
            [['nickname','address'], 'string', 'max' => 32],
            [['headimgurl'], 'string', 'max' => 256]
        ];
    }

    public function validateExe()
    {
        $member = BgadminMember::findOne(['number'=>$this->number]);
        if($this->isNewRecord) {
            if (empty($member)) {
                $this->addError('number', '该会员编号不存在，如有疑问请咨询客服查询');
            }elseif(trim(User::getNumber(Yii::$app->user->id))!=$this->number){
                $this->addError('number', '您认证的会员编号和您网站账号绑定的会员编号不一致，请联系客服核实');
                SaveToLog::log(User::getNumber(Yii::$app->user->id),"log.log");
                SaveToLog::log($this->number,"log.log");
            }else{
                if(!empty(self::findOne(['number'=>$this->number]))){
                    $this->addError('number', '该编号已经被人绑定，如有疑问请咨询客服查询');
                }elseif($member->address_a!=$this->address){
                    $this->addError('address', '与入会填写地址不符合，如有疑问请咨询客服查询');
                }
            }
        }
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                $this->created_at = time();
            }
            return true;
        } else {
            return false;
        }

    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'openid' => 'Openid',
            'number' => 'Number',
            'nickname' => 'Nickname',
            'headimgurl' => 'Headimgurl',
            'address' => 'Address',
            'created_at' => 'Created At',
        ];
    }
}
