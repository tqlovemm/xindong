<?php

namespace app\modules\user\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%thread_claims}}".
 *
 * @property string $content
 * @property string $description
 * @property integer $id
 * @property integer $created_at
 * @property integer $user_id
 * @property integer $thread_id
 */
class UserClaims extends ActiveRecord
{
    public static function tableName(){

        return '{{%thread_claims}}';

    }
    public function rules(){

        return [

            [['content','created_at','user_id','thread_id'],'required','message'=>'不可为空'],
            ['content','string'],
            ['description','string','max'=>125],

        ];


    }

}