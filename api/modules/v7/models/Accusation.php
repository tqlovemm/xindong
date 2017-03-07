<?php

namespace api\modules\v7\models;

use yii;
use app\components\db\ActiveRecord;

/**
 *  This is the model class for table "pre_app_accusation".
 * @property integer $id;
 * @property integer $user_id;
 * @property integer $words_id;
 * @property integer $reason;
 * @property integer $created_at;
 * @property integer $updated_at;
 *
 */
class Accusation extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%app_accusation}}';
    }

    public function rules()
    {
        return [
            [['words_id','user_id','reason'],'required'],
            [['id','user_id','words_id','updated_at','created_at'],'integer'],
            [['reason'],'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'    =>  'Id',
            'user_id'   =>  'user_id',
            'words_id'   =>  'words_id',
            'reason'    =>  'reason',
            'created_at'=>  'created_at',
            'updated_at'=>  'updated_at'
        ];
    }

    public function fields()
    {
        return [
            'Id' =>'id',
            'user_id','words_id','reason','created_at','updated_at'
        ];
    }
}