<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/16
 * Time: 18:06
 */

namespace api\modules\v6\models;
use Yii;
use app\components\db\ActiveRecord;


/**
 * This is the model class for table "pre_user_profile".
 *
 * @property integer $id;
 * @property integer $user_id;
 * @property string $img_url;
 * @property integer $created_at;
 * @property integer $updated_at;

 *
 */

class UserInfoImg extends  ActiveRecord
{

    public $old_img_url;

    public static function tableName()
    {
        return "{{%user_image}}";
    }

    public function rules()
    {
        return [

            [['updated_at','created_at','user_id','created_at','updated_at'],'integer'],
            [['img_url'],'string'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'user_id',
            'img_url'   =>  'img_url',
            'updated_at'   =>  'updated_at',
            'created_at'   =>  'created_at',

        ];
    }

    public function fields()
    {
        return [

            'id',
            'user_id',
            'img_url',
            'updated_at',
            'created_at',
        ];
    }
}