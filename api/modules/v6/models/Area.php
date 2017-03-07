<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/23
 * Time: 15:52
 */

namespace api\modules\v6\models;
use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model for pre_user_profile
 * @property string $address
*/

class Area extends ActiveRecord
{
    public static function tableName(){

        return '{{%user_profile}}';
    }

    public function rules(){

        return [
            [['address'],'string']
        ];
    }

    public function attributeLabels(){

        return [
            'address'  =>  '地区',
        ];
    }

    public function fields(){

        return [
            'address'  =>  'address'
        ];
    }
}