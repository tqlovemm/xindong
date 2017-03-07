<?php
namespace api\modules\v6\models;

use Yii;
use app\components\db\ActiveRecord;
use yii\db\Query;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/15
 * Time: 10:31
 */

/**
 * This is the model class for table "pre_app_collecting_files_text".
 *
 * @property integer $id;
 * @property integer $user_id;
 * @property string $weichat;
 * @property string $cellphone;
 * @property string $weibo;
 * @property string $address;
 * @property integer $age;
 * @property integer $sex;
 * @property integer $height;
 * @property integer $weight;
 * @property integer $marry;
 * @property string $job;
 * @property string $hobby;
 * @property string $like_type;
 * @property string $car_type;
 * @property string $extra;
 * @property string $flag;
 * @property integer $status;
 * @property string $often_go;
 * @property string $annual_salary;
 * @property string $qq;
 * @property integer $created_at;
 * @property integer $updated_at;
 *
 */
class MemberInfo extends ActiveRecord
{

    //public $img;
    public static function tableName()
    {
        return '{{%app_collecting_files_text}}';
    }

    public function rules()
    {
        return [
            [['id','cellphone','age','height','weight','marry','qq','user_id'],'number'],
            [['cellphone'],'match','pattern'=>'/^1[3,4,5,7,8][0-9]{9}$/'],
            [['address','job','hobby','like_type','car_type','often_go'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'member_id',
            'user_id'    =>  'user_id',
            'weichat'   =>  'weichat',
            'cellphone' =>  'cellphone',
            'weibo'     =>  'weibo',
            'address'   =>  'address',
            'age'       =>  'age',
            'sex'       =>  'sex',
            'height'    =>  'height',
            'weight'    =>  'weight',
            'marry'     =>  'marry',
            'job'       =>  'jod',
            'hobby'     =>  'hobby',
            'like_type'       =>  'like_type',
            'car_type'       =>  'car_type',
            'extra'       =>  'extra',
            'flag'       =>  'flag',
            'status'       =>  'status',
            'often_go'       =>  'often_go',
            'annual_salary'       =>  'annual_salary',
            'qq'       =>  'qq',

        ];
    }

    public function fields()
    {
        return [
            'id','user_id','weichat','cellphone','weibo','address','age','sex','height','weight','marry','job','hobby','like_type',
            'car_type','extra','flag','status','often_go','annual_salary','qq',//'img'
        ];
    }

    public function getImgs(){

        $imgs = (new Query())->select('img')->from('pre_app_collecting_files_img')->where(['text_id'=>$this->id])->all();
        $data = array();
        foreach($imgs as $list){

            $ext = explode('.',$list['img']);
            $extes = array('png','PNG','JPG','JPEG','jpg','jpeg','bmp','BMP');
            if(!in_array($ext[count($ext)-1],$extes)){continue;}
            $list['img'] = 'http://13loveme.com'.$list['img'];
            $data[] = $list['img'];
        }
        return $data;
    }

    public function extraFields()
    {
        return [
            'imgs'=> 'imgs',
        ];
    }

}