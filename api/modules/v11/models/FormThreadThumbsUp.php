<?php
namespace api\modules\v11\models;
use api\modules\v9\models\UserProfile;
use Yii;

use common\components\PushConfig;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "pre_app_form_thread_thumbs_up".
 *
 * @property integer $thumbs_id
 * @property integer $thread_id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class FormThreadThumbsUp extends ActiveRecord
{
    private $_users;
    private $_profile;
    private $_thread;
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
            ['thread_id','unique'],
        ];
    }
    public function unique(){
        $query = $this->findOne(['thread_id'=>$this->thread_id,'user_id'=>$this->user_id]);
        if(!empty($query)){
            $this->addError('user_id', '已经点赞');
        }
    }

    public function fields(){
        $this->_users = User::findOne(['id'=>$this->user_id]);

        $data = [
            'user_id','created_at','updated_at',
            'nickname'=>function(){
                return empty($this->_users->nickname)?$this->_users->username:$this->_users->nickname;
            },
            'avatar'=>function(){
                return $this->_users->avatar;
            },
        ];
        if(Yii::$app->controller->id=='form-thread-thumbs-up'){
            $this->_profile = UserProfile::findOne(['user_id'=>$this->user_id]);
            $this->_thread = FormThread::find()->where(['user_id'=>$this->user_id])->count();
            $data['thread_count']=function (){return (integer)$this->_thread;};
            $data['address']=function (){return $this->_profile->address;};
            $data['age']=function (){return floor((time()-strtotime($this->_profile->birthdate))/(86400*365));};
            $data['height']=function (){return $this->_profile->height;};
            $data['weight']=function (){return $this->_profile->weight;};
        }

        return $data;
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes); // TODO: Change the autogenerated stub

        $tuid = array();
        $cuid = array();
        $tsuid = array();
        $model = self::find()->where(['thread_id'=>$this->thread_id])->andWhere("user_id!=$this->user_id")->asArray()->all();
        $commentModel = FormThreadComments::find()->where(['thread_id'=>$this->thread_id])->andWhere("first_id!=$this->user_id")->asArray()->all();
        $thread_uid = FormThread::findOne($this->thread_id);
        if(!empty($model)){
            $tuid = ArrayHelper::map($model,'user_id','user_id');
        }
        if(!empty($commentModel)){
            $cuid = ArrayHelper::map($commentModel,'first_id','first_id');
        }
        $uids = array_unique(array_merge($cuid, $tuid));

        if($this->user_id!=$thread_uid->user_id){
            array_push($tsuid,$thread_uid->user_id);
            array_push($uids,$thread_uid->user_id);
        }

        if(!empty($tsuid)){
            $userCid = array_filter(ArrayHelper::map(User::find()->select('id,cid')->where(['id'=>$tsuid])->asArray()->all(),'id','cid'));
        }else{
            $userCid = [];
        }

        if(!empty($userCid)){
            $userModel = User::findOne($this->user_id);
            $username = empty($userModel->nickname)?$userModel->username:$userModel->nickname;
            $title="{$username}点赞帖子";
            $msg="{$username}点赞帖子";
            $data = array('push_title'=>$title,'push_content'=>$msg,'push_post_id'=>"$this->thread_id",'push_type'=>'SSCOMM_NEWSCOMMENT_DETAIL');
            $extras = json_encode($data);
            PushConfig::config();
            pushMessageToList(1, $title, $msg, $extras ,$userCid);
        }

        $data = array();
        if($this->user_id!=$thread_uid->user_id){
            $data = [[$this->thread_id,$thread_uid->user_id,$this->user_id,"",time(),time()]];
        }

    /*    foreach ($uids as $uid){
            if($uid!=$thread_uid->user_id){
                $da = [$this->thread_id,$uid,$this->user_id,"",time(),time()];
                array_push($data,$da);
            }
        }*/

        if(!empty($data)){
            \Yii::$app->db->createCommand()->batchInsert('pre_app_form_thread_push_msg', ['wid','user_id','writer_id','content','created_at','updated_at'],$data)->execute();
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thumbs_id' => 'Thumbs ID',
            'thread_id' => 'Thread ID',
            'user_id' => 'User ID',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
        ];
    }


    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){

            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

}
