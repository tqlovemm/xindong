<?php

namespace frontend\modules\test\models;
use yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%weichat_vote_good}}".
 *
 * @property integer $id
 * @property integer $vote_id
 * @property string $sayGood
 * @property integer $updated_at
 * @property integer $created_at
 */

class VoteUserGood extends ActiveRecord
{

    public static function tableName()
    {
        return "{{%weichat_vote_good}}";
    }

    public function rules()
    {
        return [
            [['vote_id','created_at','updated_at'],'integer'],
            [['sayGood'],'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'vote_id'   =>  '评选者ID',
            'sayGood'      =>  '点赞者的openid',
        ];
    }

    public function beforeSave($insert)
    {

        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}