<?php
namespace api\modules\v11\models;

use app\components\db\ActiveRecord;
/**
 * This is the model class for table "pre_app_form_thread_push_msg".
 *
 * @property integer $pid
 * @property integer $wid
 * @property integer $user_id
 * @property integer $writer_id
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $read_user
 * @property integer $type
 * @property string $content
 */
class FormThreadPushMsg extends ActiveRecord
{
    private $_thread;
    private $_user;
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
            [['user_id', 'wid','writer_id'], 'required','message'=>"{attribute}不可为空"],
            [['user_id', 'wid', 'writer_id','created_at', 'read_user','updated_at','type'], 'integer'],
            ['content','string'],
        ];
    }


    public function fields(){

        $this->_thread = FormThread::findOne($this->wid);
        $this->_user = User::findOne([$this->writer_id]);
        return [
            'mid'=>"pid","wid",'user_id', 'read_user','created_at',
            'avatar'=>function(){return $this->_user->avatar;},
            'nickname'=>function(){return !empty($this->_user->nickname)?$this->_user->nickname:$this->_user->username;},
            'imgItemsArray'=>function(){
                return !empty($this->_thread->cover)?$this->_thread->cover:'';
            },
            'unreadContent'=>function(){
                return !empty($this->_thread->content)?$this->_thread->content:'';
            },
            'content'=>function(){
                if($this->type==2){
                    return "";
                }else{
                    return $this->content;
                }

            },
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
            'writer_id' => 'Writer ID',
            'read_user' => 'Read User',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'type' => 'Type',
            'content' => 'Content',
        ];
    }

}
