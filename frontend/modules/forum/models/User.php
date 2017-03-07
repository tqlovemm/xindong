<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/12
 * Time: 14:29
 */

namespace frontend\modules\forum\models;
use yii\db\ActiveRecord;

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

}


?>
