<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;




/**
 * This is the model class for table "pre_dating_signup".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $msg
 * @property string $like_id
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $area
 * @property integer $status
 * @property integer $type
 * @property string $avatar
 * @property integer $worth
 */
class DatingSignup extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%dating_signup}}';
    }

    public function rules()
    {
        return [
            [['user_id','like_id'],'required'],
            [['user_id','type','created_at','updated_at','worth','status'], 'integer'],
            [['like_id','extra','msg','area','avatar'], 'string'],
        ];
    }
    public function attributeLabels()
    {
        return [

            'user_id' => '会员ID',
            'msg' => 'Msg',
            'like_id' => '妹子编号',
            'area' => '地区',
            'created_at' => 'created_at',
            'updated_at' => 'updated_at',
            'status' => '状态',
            'worth' => '价值',
            'avatar' => '头像',
            'type' => '类型',
            'extra' => '其他',
        ];
    }

    public function fields()
    {

        return [
            'id','user_id','like_id','area','created_at','status','worth','avatar','type','msg','extra'

        ];

    }


}


?>
