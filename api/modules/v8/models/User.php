<?php

namespace api\modules\v8\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\db\Query;


/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $username
 * @property string $avatar
 * @property string $nickname
 * @property integer $sex
 * @property string $openId
 * @property integer $created_at
 * @property integer $update_at
 */
class User extends ActiveRecord
{

    public $birthdate="";
    public $address="";
    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['username','avatar','birthdate','sex','openId',"nickname"],'required'],
            [['id','sex','created_at','updated_at'], 'integer'],
            [['username','avatar','nickname','identify','openId','address','cid','none','password_reset_token'], 'string'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => '该用户名已注册.'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'cid' => 'cid',
            'username' => '会员名',
            'avatar' => '会员头像',
            'nickname' => '用户昵称',
            'sex' => '性别',
            'openId' => 'openid',
            'birthdate' => '生日',
            'address' => '用户地址',
            'none' => '环信密码',
            'identify' => '微信号',
        ];
    }

    public function fields()
    {

        return [
            'id','cid','username','avatar','nickname','sex','address','openId','birthdate','created_at','none',
            'password_reset_token',
            'identify',
        ];

    }

    public function getAvatar(){

        $avatar = (new Query())->select('avatar')->from('pre_user')->where(['id'=>$this->id])->one();
        return $avatar['avatar'];
    }


}
?>
