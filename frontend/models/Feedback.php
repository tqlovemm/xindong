<?php

namespace frontend\models;
use Yii;
use yii\base\Model;
use yii\db\ActiveRecord;

class Feedback extends ActiveRecord
{

    public static function tableName()
    {
        return '{{%user_feedback}}';
    }

    public function rules(){

        return [

            [['title','content',/*'created_by',*/'created_at'],'required'],

            ['title', 'string', 'max' => 100, 'min' => 4],

        ];


    }
    public function attributeLabels()
    {
        return [
            'title' =>'主题',
            'content' => '内容',
            'created_by' => Yii::t('app','Created By'),
            'created_at' => Yii::t('app','Created At'),

        ];
    }

}