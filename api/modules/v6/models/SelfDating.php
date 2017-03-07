<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/30
 * Time: 13:46
 */

namespace api\modules\v6\models;

use yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_app_selfdating".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $sex
 * @property integer $level
 * @property integer $pay
 * @property integer $nickname
 * @property integer $address
 * @property integer $avatar
 * @property integer $expire
 * @property string $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class SelfDating extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%app_selfdating}}';
    }

    public function rules(){

        return [
            [['id','user_id','sex','pay','expire','created_at','updated_at','level','status'],'integer'],
            [['nickname','address','avatar',],'string']
        ];
    }

    public function attributeLabels(){

        return [
            'id'    =>  '发布觅约id',
            'user_id'   =>  '发布觅约用户id',
            'sex'   =>  '发布觅约用户性别',
            'level' =>  '发布觅约用户等级',
            'avatar'=>  '用户头像',
            'pay' =>  '觅约付费',
            'status'=>  '发布觅约状态',
            'expire'=>  '觅约有效时长',
            'created_at'    =>  '觅约发布时间',
            'updated_at'    =>  'updated_at'
        ];
    }

    public function fields(){

        return [
            'id','user_id','sex','level','avatar','nickname','pay','status','expire','created_at','updated_at',
        ];
    }
}