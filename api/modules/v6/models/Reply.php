<?php

namespace api\modules\v6\models;

use yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_app_words_comment".
 * @property integer $id;
 * @property integer $words_id;
 * @property integer $first_id;
 * @property integer $second_id;
 * @property string $avatar;
 * @property string $comment;
 * @property string $img;
 * @property integer $flag;
 * @property integer $created_at;
 * @property integer $updated_at;
 */
class Reply extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%app_words_comment}}";
    }

    public function rules(){

        return [
            [['words_id','first_id','comment'],'required'],
            [['words_id','created_at','updated_at','first_id','second_id','flag','id'],'integer'],
            [['comment','img'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'ID',
            'words_id'  =>  '帖子id',
            'first_id'   =>  'first_id',
            'second_id'  =>  'second_id',
            'comment'    =>  'comment',
            'img'  =>  'img',
            'flag'  =>  'flag',
            'created_at'    =>  'created_at',
            'updated_at'    =>  'updated_at',
        ];
    }

    public function fields(){

        return [
            'reply_id'=>'id',
            'words_id',
            'first_id',
            'second_id',
            'comment',
            'img',
            'flag',
            'created_at',
            'updated_at',
        ];
    }
}