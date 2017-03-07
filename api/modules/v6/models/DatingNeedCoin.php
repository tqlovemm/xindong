<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/9/5
 * Time: 10:11
 */

namespace api\modules\v6\models;

use yii;
use app\components\db\ActiveRecord;

class DatingNeedCoin extends ActiveRecord
{

    public static function tableName(){

        return '{{%user}}';
    }

    public function rules()
    {
        return [
            [['id','groupid','sex'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'groupid'   =>  '用户等级',
            'sex'=> 'sex',
        ];
    }

    public function fields()
    {
        return [
            'id','groupid','sex',
        ];

    }
}