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
 * @property string $img_url;
 * @property string $signature;
 * @property integer $weight;
 * @property integer $height;
 * @property integer $flag;
 * @property integer $is_marry;
 * @property integer $status;
 *
 */

class UserInfo extends  ActiveRecord
{

    public $jiecao_coin;
    public $nickname;
    public $img_url;
    public $flag;

    public static function tableName()
    {
        return "{{%user_profile}}";
    }

    public function rules()
    {
        return [
            [['user_id','nickname','address','birthdate','mark','make_friend','weight','height'],'required'],
            [['user_id','flag'],'integer'],
            [['mark','make_friend','address','img_url','signature'],'string'],
            [['weight','height'],'number'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'user_id' => 'user_id',
            'nickname'  =>  'nickname',
            'number'  =>  'number',
            'address'   =>  'address',
            'birthdate' =>  'birthdate',
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
            //'username',
            'nickname'=>'name',
            'title'=>'address',
            'birthdate',
            'sex',
            'avatar',
            'content'=> function($model){
                if($model['mark'] != null){
                    $content = json_decode($model['mark']);
                    return $content;
                }
            },
            'url'=> function($model){
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

   /* public function getUsername(){

        $username = (new Query())->select('username')->from('pre_user')->where(['id'=>$this->user_id])->one();
        return $username['username'];
    }*/

    public function getSex(){

        $sex = (new Query())->select('sex')->from('pre_user')->where(['id'=>$this->user_id])->one();
        return $sex['sex'];
    }

    public function getName(){

        $nickname = (new Query())->select('*')->from('pre_user')->where(['id'=>$this->user_id])->one();
        return $nickname['nickname'];
    }
    public function getPhotos(){

        $img_url = (new Query())->select('img_url as path')->from('pre_user_image')->where(['user_id'=>$this->user_id])->all();
        return $img_url;
    }

    public function getAvatar(){

        $avatar = (new Query())->select('avatar')->from('pre_user')->where(['id'=>$this->user_id])->one();
        return $avatar['avatar'];
    }

    public function extraFields()
    {
        return [
            'photos'=> 'photos',
        ];
    }

}