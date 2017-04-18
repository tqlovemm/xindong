<?php
namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;
use api\modules\v9\models\UserProfile;
/**
 * This is the model class for table "pre_app_form_thread".
 *
 * @property integer $wid
 * @property integer $user_id
 * @property string $content
 * @property string $lat_long
 * @property string $tag
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $is_top
 * @property integer $type
 * @property integer $status
 * @property integer $sex
 * @property integer $read_count
 * @property integer $thumbs_count
 */
class FormThread extends ActiveRecord
{
    private $_user;
    private $_thumbs_up;
    private $_user_id;
    private $_comment;
    public $base64Images;
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
            [['user_id', 'type', 'is_top', 'sex','read_count','thumbs_count','created_at', 'status','updated_at'], 'integer'],
            [['content','base64Images'], 'string'],
            [['lat_long','tag'], 'string','max'=>128],
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
        $this->_thumbs_up = FormThreadThumbsUp::findAll(['thread_id'=>$this->wid]);
        $this->_comment = FormThreadComments::findAll(['thread_id'=>$this->wid]);
        return [
            "wid",'user_id', 'content','sex','tag','is_top','type','read_count','thumbs_count','created_at',

            'nickname'=>function(){return empty($this->_user->nickname)?$this->_user->username:$this->_user->nickname;},

            'avatar'=>function(){return $this->_user->avatar;},

            'address'=>function(){return UserProfile::findOne(['user_id'=>$this->user_id])->address;},

            'imgItemsArray'=>function(){return FormThreadImages::findAll(['thread_id'=>$this->wid,'status'=>10]);},

            'liked'=>function(){return empty(FormThreadThumbsUp::findOne(['thread_id'=>$this->wid,'user_id'=>$this->_user_id]))?0:1;},

            'likeCount'=>function(){return count($this->_thumbs_up);},

            'likeItemsArray'=>function(){return $this->_thumbs_up;},

            'commentCount'=>function(){return count($this->_comment);},

            'commentItemsArray'=>function(){return $this->_comment;},
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
            'sex' => 'Sex',
            'content' => 'Content',
            'is_top' => 'Is Top',
            'updated_at' => 'Updated At',
            'created_at' => 'Created At',
            'status' => 'Status',
            'tag' => 'Tag',
            'type' => 'Type',
            'lat_long' => 'Lat Long',
            'read_count' => 'Read Count',
            'thumbs_count' => 'Thumbs Count',
            'base64Images' => 'Base64 Images',
        ];
    }

}
