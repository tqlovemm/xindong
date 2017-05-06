<?php
namespace api\modules\v11\models;

use app\components\db\ActiveRecord;
/**
 * This is the model class for table "pre_app_form_thread_push_msg".
 *
 * @property integer $pid
 * @property integer $wid
 * @property integer $user_id
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $read_user
 */
class FormThreadPushMsg extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread_push_msg}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'wid'], 'required','message'=>"{attribute}不可为空"],
            [['user_id', 'wid', 'created_at', 'read_user','updated_at'], 'integer'],
        ];
    }


    public function fields(){

        return [
            "wid",'user_id', 'read_user','created_at',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'wid' => 'WID',
            'user_id' => 'User ID',
            'read_user' => 'Read User',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }

}
