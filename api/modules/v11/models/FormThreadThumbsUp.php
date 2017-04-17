<?php
namespace api\modules\v11\models;

use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_app_form_thread_thumbs_up".
 *
 * @property integer $id
 * @property integer $thread_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class FormThreadThumbsUp extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread_thumbs_up}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'user_id'], 'required'],
            [['thread_id', 'user_id', 'created_at','updated_at'], 'integer'],
        ];
    }

    public function fields(){

        return [
            'user_id',
            'avatar'=>function(){
                return User::findOne(['id'=>$this->user_id])->avatar;
            },
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'thread_id' => 'Thread ID',
            'user_id' => 'User ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

}
