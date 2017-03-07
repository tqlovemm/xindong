<?php

namespace api\modules\v6\models;

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
            [['title','content','url','avatar'],'string']
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
            'worth' =>  '女生觅约价值',
            'status'=>  '发布觅约状态',
            'expire'=>  '觅约有效时长',
            'created_at'    =>  '觅约发布时间',
            'updated_at'    =>  'updated_at'
        ];
    }

    public function fields(){

        return [
            'dating_id'=>'id','number','title','created_at','avatar','status','worth','expire',
            'url'=>function($model){

                return explode('，',$model['url']);

            } ,
            'content'=>function($model){

                return explode('，',$model['content']);

            },'photos',
        ];
    }

    public function getPhotos(){

        $photo = Yii::$app->db->createCommand("select path from {{%weekly_content}} where album_id=$this->id")->queryAll();

        return $photo;
    }
}