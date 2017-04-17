<?php
namespace api\modules\v11\models;

use api\modules\v9\models\UserProfile;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_app_form_thread_comments".
 *
 * @property integer $comment_id
 * @property integer $thread_id
 * @property string $comment
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $flag
 * @property integer $first_id
 * @property integer $second_id
 */
class FormThreadComments extends ActiveRecord
{
    private $_first;
    private $_second;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread_comments}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thread_id', 'comment','first_id'], 'required'],
            [['thread_id', 'created_at', 'flag','updated_at','first_id','second_id'], 'integer'],
            [['comment'], 'string']
        ];
    }

    public function fields(){

        $this->_first = User::findOne(['id'=>$this->first_id]);
        $this->_second = User::findOne(['id'=>$this->second_id]);

        $data = array(
            'comment_id','words_id'=>'thread_id', 'comment', 'created_at','updated_at', 'flag','first_id','second_id',
            'firstUrl'=>function(){
                return $this->_first->avatar;
            },
            'firstName'=>function(){
                return $this->_first->username;
            },
        );

        if(!empty($this->_second)){
            $data['secondUrl'] = function (){return $this->_second->avatar;};
            $data['secondName'] = function (){return $this->_second->username;};
        }


        return $data;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'comment_id' => 'Comment ID',
            'thread_id' => 'Thread ID',
            'comment' => 'Comment',
            'first_id'=>'First ID',
            'second_id'=>'Second ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'flag' => 'Flag',
        ];
    }

}
