<?php
namespace api\modules\v11\models;

use app\components\db\ActiveRecord;
use common\components\PushConfig;
use yii\helpers\ArrayHelper;
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

        $this->_first = User::findOne($this->first_id);
        $this->_second = User::findOne($this->second_id);

        $data = array(
            'comment_id','words_id'=>'thread_id', 'comment', 'created_at','updated_at', 'flag',
            'first_id'=>function(){
                return "$this->first_id";
            },
            'second_id'=>function(){
                return "$this->second_id";
            },
            'firstUrl'=>function(){
                return $this->_first['avatar'];
            },
            'firstName'=>function(){
                return empty($this->_first['nickname'])?$this->_first['username']:$this->_first['nickname'];
            },
        );

        if(!empty($this->_second)){
            $data['secondUrl'] = function (){return $this->_second['avatar'];};
            $data['secondName'] = function (){return empty($this->_second['nickname'])?$this->_second['username']:$this->_second['nickname'];};
        }

        return $data;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        PushConfig::config();

        $tuid = array();
        $cuid = array();
        $model = self::find()->where(['thread_id'=>$this->thread_id])->andWhere("first_id!=$this->first_id")->asArray()->all();
        $thumbModel = FormThreadThumbsUp::find()->where(['thread_id'=>$this->thread_id])->andWhere("user_id!=$this->first_id")->asArray()->all();
        if(!empty($thumbModel)){
            $tuid = ArrayHelper::map($thumbModel,'user_id','user_id');
        }

        if(!empty($model)){
            $cuid = ArrayHelper::map($model,'first_id','first_id');
        }
        $uids = array_merge($cuid, $tuid);

        if(!empty($uids)){
            $userCid = array_filter(ArrayHelper::map(User::find()->where(['id'=>$uids])->asArray()->all(),'cid','cid'));
        }else{
            $userCid = "";
        }
        $thread_uid = FormThread::findOne($this->thread_id)->user_id;

        if(!empty($userCid)){

            $userModel = User::findOne($this->first_id);
            $username = empty($userModel->nickname)?$userModel->username:$userModel->nickname;
            $title="评论帖子：【{$username}】评价了你：【{$this->comment}】";
            $msg="评论帖子：【{$username}】评价了你：【{$this->comment}】";
            $data = array('push_title'=>$title,'push_content'=>$msg,'push_type'=>'SSCOMM_NOTICE');
            $extras = json_encode($data);

            pushMessageToList(1, $msg , $extras , $title , $userCid);
        }

        $data = array();
        if($this->first_id!=$thread_uid){
            $data = [[$this->thread_id,$thread_uid,$this->first_id,$this->comment,time(),time()]];
        }

        foreach ($uids as $uid){
            if($uid!=$thread_uid){
                $da = [$this->thread_id,$uid,$this->first_id,$this->comment,time(),time()];
                array_push($data,$da);
            }
        }

        if(!empty($data)){
            \Yii::$app->db->createCommand()->batchInsert('pre_app_form_thread_push_msg', ['wid','user_id','writer_id','content','created_at','updated_at'],$data)->execute();
        }
    /*    $model = self::find()->where(['thread_id'=>$this->thread_id])->andWhere("first_id!=$this->first_id")->asArray()->all();
        $uids = ArrayHelper::map($model,'first_id','first_id');
        $userCid = array_filter(ArrayHelper::map(User::find()->where(['id'=>$uids])->asArray()->all(),'cid','cid'));
        $thread_uid = FormThread::findOne($this->thread_id)->user_id;
        pushMessageToList(1, $msg , $extras , $title , $userCid);
        $data = array();
        if($this->_first!=$thread_uid){
            $data = [[$this->thread_id,$thread_uid,$this->first_id,$this->comment,time(),time()]];
        }

        foreach ($uids as $uid){
            if($uid!=$thread_uid){
                $da = [$this->thread_id,$uid,$this->first_id,$this->comment,time(),time()];
                array_push($data,$da);
            }
        }

        \Yii::$app->db->createCommand()->batchInsert('pre_app_form_thread_push_msg', ['wid','user_id','writer_id','content','created_at','updated_at'],$data)->execute();*/
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
