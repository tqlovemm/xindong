<?php

namespace api\modules\v8\models;

use yii;
use app\components\db\ActiveRecord;

/**
 * This is the model for pre_weekly
 * @property integer $id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property string $avatar
 * @property integer $worth
 * @property integer $number
 * @property integer $expire
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 *
 *
 */
class Dating extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%weekly}}';
    }

    public function rules(){

        return [
            [['id','created_at','updated_at','worth','expire','number','status'],'integer'],
            [['title','content','url','avatar','introduction'],'string']
        ];
    }

    public function attributeLabels(){

        return [
            'id'    =>  '发布觅约id',
            'avatar'   =>  'avatar',
            'title'   =>  'title',
            'number' =>  'number',
            'content'=>  'content',
            'url'=>  'url',
            'introduction'=>  'introduction',
            'worth' =>  '女生觅约价值',
            'status'=>  '发布觅约状态',
            'expire'=>  '觅约有效时长',
            'created_at'    =>  '觅约发布时间',
            'updated_at'    =>  'updated_at'
        ];
    }

    public function fields(){

        return [
            'dating_id'=>'id','title','created_at',
            'avatar'=>function($model){
                $pre_url = Yii::$app->params['shisangirl'];
                return $pre_url.$model['avatar'];

            } ,
            'status','worth','expire','introduction',
            'url'=>function($model){

                return explode('，',$model['url']);

            } ,
            'content'=>function($model){

                return explode('，',$model['content']);

            },
            'number',
            'photos',
            'chatImg'
        ];
    }

    public function getPhotos(){
        $pre_url = Yii::$app->params['shisangirl'];
        $photo = Yii::$app->db->createCommand("select CONCAT('$pre_url',path) as path from {{%weekly_content}} where album_id=$this->id and status = 0")->queryAll();

        return $photo;
    }

    public function getChatImg(){
        $pre_url = Yii::$app->params['shisangirl'];
        $photo = Yii::$app->db->createCommand("select CONCAT('$pre_url',path) as path from {{%weekly_content}} where album_id=$this->id and status = 1")->queryAll();
        return $photo;
    }
}