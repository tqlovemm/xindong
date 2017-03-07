<?php

namespace frontend\modules\test\models;
use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%weichat_vote_img}}".
 *
 * @property integer $id
 * @property integer $vote_id
 * @property string $path
 * @property string $thumb
 * @property integer $status
 * @property integer $updated_at
 * @property integer $created_at
 */

class VoteUserImg extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%weichat_vote_img}}";
    }

    public function rules()
    {
        return [
            [['vote_id','status','created_at','updated_at'],'integer'],
            [['path','thumb'],'string','max'=>128],
        ];
    }

    public function attributeLabels()
    {
        return [
            'vote_id'   =>  '评选者ID',
            'path'      =>  '原图路径',
            'thumb'     =>  '缩略图路径',
        ];
    }
}