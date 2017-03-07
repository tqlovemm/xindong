<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/22
 * Time: 14:50
 */

namespace api\modules\v6\models;
use yii;
use yii\db\Query;
use app\components\db\ActiveRecord;


/**
 * This is the model class for table "pre_user_profile".
 *  @property integer $user_id
 *  @property string $number
 *  @property string $address
 *  @property integer $created_at
 *  @property integer $updated_at
 *  @property integer $status
 *  @property string $mark
 *  @property string $is_marry
 *  @property string $make_friend
 *  @property integer $worth
*/
class UserDating extends  ActiveRecord
{

    public $sex;
    //public $dating_no;
    //public $username;
    public static function tableName()
    {
        return '{{%user_profile}}';
    }

    public function rules(){

        return [
            [['user_id','created_at','status','is_marry'],'integer'],
            [['number','address','mark','make_friend'],'string'],
        ];
    }

    public function attributeLabels(){

        return [
            'user_id'   =>  'user_id',
            'created_at'=>  'created_at',
            'status'    =>  'status',
            'worth'     =>  'worth',
            'number'    =>  'number',
            'address'   =>  'address',
            'username'   =>  'username',
            'mark'      =>  'mark',
            'is_marry'      =>  'is_marry',
            'make_friend'   =>  'make_friend',
        ];
    }

    public function fields(){

        return [
            'dating_id'=>'user_id',
            'worth'/* => function($model){
                if(!$model['worth']){
                    return 50;
                }else{
                    return $model['worth'];
                }

            }*/,
            'dating_no',
            'number',
            'title'=>'address',
            'mark' => function($model){

                $model['mark'] = json_decode($model['mark']);
                return $model['mark'];
            },
            'make_friend'=>function($model){
                $model['make_friend'] = json_decode($model['make_friend']);
                return $model['make_friend'];
            },
            'is_marry',
            'username',
            'sex',
            'created_at',
            'status',
            'avatar',
            'photos',
        ];
    }


    public function getAvatar(){

        $avatar = (new Query())->from('{{%user}}')->where(['id'=>$this->user_id])->one();
        return $avatar['avatar'];
    }

    public function getUserName(){

        $username = (new Query())->select('username')->from('{{%user}}')->where(['id'=>$this->user_id])->one();
        return $username['username'];
    }

    public function getPhotos(){

        $photos = (new Query())->select('img_url as path')->from('{{%user_image}}')->where(['user_id'=>$this->user_id])->all();
        return $photos;
    }


}


