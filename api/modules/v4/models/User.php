<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\db\Query;


/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property integer $username
 * @property integer $avatar
 * @property integer $nickname
 */
class User extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user}}';
    }

    public function rules()
    {
        return [

            [['id'], 'integer'],
            [['username','avatar','nickname'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'id' => 'ID',
            'username' => '会员名',
            'avatar' => '会员头像',
            'nickname' => '用户昵称',
        ];
    }

    public function fields()
    {

        return [
            'id','username','avatar','nickname'
        ];

    }

    public function getAvatar(){

        $avatar = (new Query())->select('avatar')->from('pre_user')->where(['id'=>$this->id])->one();
        return $avatar['avatar'];
    }


}


?>
