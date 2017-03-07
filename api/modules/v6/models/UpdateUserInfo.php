<?php

namespace api\modules\v6\models;
use Yii;
use app\components\db\ActiveRecord;
use yii\db\Query;


/**
 * This is the model class for table "pre_user_profile".
 *
 * @property integer $id;
 * @property integer $user_id;
 * @property string $nickname;
 * @property string $address;
 * @property integer $birthdate;
 * @property string $mark;
 * @property string $make_friend;
 * @property string $signature;
 * @property integer $weight;
 * @property integer $height;
 * @property integer $flag;
 * @property integer $is_marry;
 * @property integer $status;
 *
 */

class UpdateUserInfo extends  ActiveRecord
{
    public $img_url;
    public $nickname;
    public $sex;
    public $jiecao_coin;
    //public $id;

    public static function tableName()
    {
        return "{{%user_profile}}";
    }

    public function rules()
    {
        return [
            //[['nickname','address','birthdate','mark','make_friend','weight','height'],'required'],
            [['user_id','flag','is_marry','worth'],'integer'],
            //[['birthdate'],'date'],
            [['mark','make_friend','address','signature','nickname','birthdate','img_url'],'string'],
            [['weight','height'],'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'user_id',
            'nickname'  =>  'nickname',
            'number'  =>  'number',
            'worth'  =>  'worth',
            'address'   =>  'address',
            'birthdate' =>  'birthdate',
            'is_marry' =>  'is_marry',
            'mark'  =>  'mark',
            'make_friend'   =>  'make_friend',
            'weight'    =>  'weight',
            'height'    =>  'height',
            'jiecao_coin'    =>  'jiecao_coin',
            'img_url'   =>  'img_url',
            'signature' =>  '个人签名',
            'flag'      =>  '审核状态',
            'status'    =>  '觅约状态',
        ];
    }

    public function fields()
    {
        return [
            'dating_id'=>'user_id',
            'number',
            'is_marry',
            'nickname',
            'title'=>'address',
            'birthdate',
            'sex',
            'avatar',
            'mark'=> function($model){
                if($model['mark'] != null){
                    $content = json_decode($model['mark']);
                    return $content;
                }
            },
            'make_friend'=> function($model){
                $url = json_decode($model['make_friend']);
                return $url;
            },
            'worth' => function($model){
                if(!$model['worth']){
                    return 50;
                }else{
                    return $model['worth'];
                }

            },
            'created_at',
            'weight',
            'height',
            'photos',
            'signature',
            'flag',
            'status',
        ];
    }


    public function getPhotos(){

        $img_url = (new Query())->select('img_url')->from('pre_user_image')->where(['user_id'=>$this->user_id])->all();
        $data = array();
        foreach($img_url as $list){
            $data[] = $list['img_url'];
        }
        return $data;
    }

    public function getAvatar(){

        $avatar = (new Query())->select('avatar')->from('pre_user')->where(['id'=>$this->user_id])->one();
        return $avatar['avatar'];
    }

    /*public function extraFields()
    {
        return [
            'photos'=> 'photos',
        ];
    }*/

}