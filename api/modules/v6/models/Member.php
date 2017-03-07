<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/9
 * Time: 16:25
 */

namespace api\modules\v6\models;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 */

class Member extends ActiveRecord
{

    public static function tableName(){

        return '{{%user}}';
    }

    public function rules()
    {
        return [
            //[['id'],'required'],
            [[['id'],'integer']],
        ];
    }

    public function attributeLabels(){

        return [
            'id'    =>  '用户id',
            'groupid'   =>  '会员等级',

        ];
    }

    public function fields()
    {
        return [
            'id',
            'groupid',
        ];
    }
}