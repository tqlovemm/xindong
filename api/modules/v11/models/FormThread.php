<?php
namespace api\modules\v11\models;

use api\modules\v2\models\Ufollow;
use common\models\AppFormThread;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "pre_app_form_thread".
 *
 * @property integer $wid
 * @property integer $user_id
 * @property string $content
 * @property string $lat_long
 * @property string $address
 * @property string $tag
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $is_top
 * @property integer $type
 * @property integer $status
 * @property integer $sex
 * @property integer $read_count
 * @property integer $thumbs_count
 * @property integer $comments_count
 * @property integer $admin_count
 * @property double $total_score
 */
class FormThread extends ActiveRecord
{
    private $_user;
    private $_thumbs_up;
    private $_user_id;
    private $_comment;
    public $base64Images;
    public $username;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%app_form_thread}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'sex'], 'required','message'=>"{attribute}不可为空"],
            [['user_id', 'type', 'is_top', 'sex','read_count','thumbs_count','created_at', 'status','updated_at','comments_count','admin_count'], 'integer'],
            [['content','base64Images'], 'string'],
            [['total_score'], 'number'],
            [['lat_long','tag','address'], 'string','max'=>128],
            [['content'], 'requiredWithout', 'skipOnEmpty' => false, 'skipOnError' => false],
        ];
    }

    public function requiredWithout(){

        if(!$this->content&&!$this->base64Images){
            $this->addError('content', '内容和图片不可同时为空');
        }
    }

    public function fields(){

        $this->_user_id = Yii::$app->request->get('user_id');
        $this->_user = User::findOne(['id'=>$this->user_id]);

        if(Yii::$app->controller->action->id=="view"){
            $this->_comment = FormThreadComments::findAll(['thread_id'=>$this->wid]);
            $this->_thumbs_up = FormThreadThumbsUp::findAll(['thread_id'=>$this->wid]);
        }else{
            $this->_comment = FormThreadComments::find()->where(['thread_id'=>$this->wid])->limit(5)->all();
            $this->_thumbs_up = FormThreadThumbsUp::find()->where(['thread_id'=>$this->wid])->limit(5)->all();
        }

        return [
            "wid",'user_id', 'content','sex','tag','is_top','type','created_at','groupid'=>function(){
                return $this->_user->groupid;
            },

            'follow'=>function(){
                $follow = Ufollow::findOne(['user_id'=>$this->_user_id,'people_id'=>$this->user_id]);
                return empty($follow)?0:1;
            },
            'nickname'=>function(){return empty($this->_user->nickname)?$this->_user->username:$this->_user->nickname;},

            'avatar'=>function(){return $this->_user->avatar;},

            'address',

            'imgItemsArray'=>function(){return FormThreadImages::findAll(['thread_id'=>$this->wid,'status'=>10]);},

            'liked'=>function(){return empty(FormThreadThumbsUp::findOne(['thread_id'=>$this->wid,'user_id'=>$this->_user_id]))?0:1;},

            'likeCount'=>function(){return (integer)FormThreadThumbsUp::find()->where(['thread_id'=>$this->wid])->count();},

            'likeItemsArray'=>function(){return $this->_thumbs_up;},

            'commentCount'=>function(){return (integer)FormThreadComments::find()->where(['thread_id'=>$this->wid])->count();},

            'commentItemsArray'=>function(){return $this->_comment;},
        ];
    }

    public function getCover(){

        return $this->hasMany(FormThreadImages::className(), ['thread_id' => 'wid']);
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

    public function attributeLabels()
    {
        return [
            'wid' => 'WID',
            'user_id' => 'User ID',
            'sex' => 'Sex',
            'content' => 'Content',
            'is_top' => 'Is Top',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'status' => 'Status',
            'tag' => 'Tag',
            'type' => 'Type',
            'lat_long' => 'Lat Long',
            'address' => 'Address',
            'read_count' => 'Read Count',
            'thumbs_count' => 'Thumbs Count',
            'comments_count' => 'Comments Count',
            'admin_count' => 'Admin Count',
            'total_score' => 'Total Score',
            'base64Images' => 'Base64 Images',
        ];
    }
    public function upload()
    {
        $pre = Yii::$app->params['appimages'];
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->wid;
        $qiniu = $qn->upload('appimages',$mkdir);

        $imgInfo = getimagesize($pre.$qiniu['key']);

        $model = new FormThreadImages();
        $model->img_path = $pre.$qiniu['key'];
        $model->thread_id = $this->wid;
        $model->img_width = $imgInfo[0];
        $model->img_height = $imgInfo[1];
        $model->save();
    }

    public function getComment(){

        return $this->hasMany(FormThreadComments::className(), ['thread_id' => 'wid']);

    }

    public function getThumbs(){

        return $this->hasMany(FormThreadThumbsUp::className(), ['thread_id' => 'wid']);
    }
}
