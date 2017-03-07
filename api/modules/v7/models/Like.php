<?php

namespace api\modules\v7\models;

use yii;
use api\modules\v6\models\Word;
use app\components\db\ActiveRecord;

/**
 *  This is the model class for table "pre_app_words_like".
 * @property integer $id;
 * @property integer $words_id;
 * @property integer $user_id;
 * @property integer $created_at;
 * @property integer $updated_at;
 *
 */

class Like extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%app_words_like}}';
    }

    public function rules()
    {
        return [
            [['words_id','user_id'],'required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  '点赞id',
            'words_id' =>  '帖子id',
            'user_id'=> '点赞用户id',
            'created_at'    =>  'created_at',
            'updated_at'    =>  'updated_at'
        ];
    }

    public function fields()
    {
        return [
            'like_id'=>'id','words_id','user_id','created_at','user','count','age'
        ];
    }

    protected function getCount(){
        $count = Word::find()->where(['user_id'=>$this->user_id])->count();
        return $count;
    }

    protected function getAge(){
        $age = (new yii\db\Query())->select('birthdate')->from('{{%user_profile}}')->where(['user_id'=>$this->user_id])->one();
        if(!$age['birthdate']){
            $uage = '年龄不详';
        }else{
            $uage = (string)(date('Y',time())-$age['birthdate']);
        }
        return $uage;
    }

    protected function getUser(){

        $info = (new yii\db\Query())
            ->select('avatar,sex,address,height,weight,nickname,username')
            ->from('pre_user as user')
            ->leftJoin('pre_user_profile as pro','pro.user_id=user.id')
            ->where(['user.id'=>$this->user_id])
            ->one();

        if(!$info['nickname']){
            $info['nickname'] = $info['username'];
        }
        unset($info['username']);
        return $info;
    }






}