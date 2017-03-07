<?php

namespace api\modules\v8\models;

use yii;
use app\components\db\ActiveRecord;

/**
 * This is the model for pre_weekly_content
 * @property integer $id
 * @property string $album_id
 * @property string $name
 * @property string $thumb
 * @property string $path
 * @property integer $store_name
 * @property integer $is_cover
 * @property integer $status
 * @property integer $created_at
 * @property integer $created_by
 *
 *
 */
class DatingContent extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%weekly_content}}';
    }

    public function rules(){

        return [
            [['id','album_id','created_at','created_by','is_cover','status'],'integer'],
            [['name','thumb','path','store_name'],'string']
        ];
    }

    public function attributeLabels(){

        return [
            'id'    =>  'Id',
            'is_cover'   =>  'is_cover',
            'album_id'   =>  'album_id',
            'name'   =>  'name',
            'thumb' =>  'thumb',
            'path'=>  'path',
            'store_name'=>  'store_name',
            'created_by'=>  'created_by',
            'status'=>  'status',
            'created_at'    =>  'created_at',
        ];
    }

    public function fields(){

        return [
            'id','name','thumb','store_name',
        ];
    }

}