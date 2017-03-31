<?php

namespace backend\modules\weekly\models;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\db\Query;
use backend\components\Uploader;

/**
 * This is the model class for table "{{%weekly}}".
 *
 * @property string $id
 * @property string $title
 * @property string $title2
 * @property string $title3
 * @property string $content
 * @property string $url
 * @property string $cover_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $enable_comment
 * @property integer $status
 * @property integer $worth
 * @property string $flag
 * @property string $number
 * @property string $avatar
 * @property integer $platform
 */
class Weekly extends \yii\db\ActiveRecord
{
    const TYPE_PUBLIC = 0;
    const TYPE_PASSWORD = 1;
    const TYPE_QUESTION = 2;
    const TYPE_PRIVATE = 3;
    const COVER_NONE = 0;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weekly}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','content','url'], 'required'],
            [['cover_id', 'created_at', 'updated_at', 'created_by', 'enable_comment', 'status','worth','platform'], 'integer'],
            [['title','content','url','title2','title3','avatar'], 'string', 'max' => 256],
            [['flag','number'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => '标题',
            'title2' => '标题二',
            'number' => '编号',
            'title3' => '标题三',
            'content' => '内容',
            'url'=>'Url',
            'cover_id' => Yii::t('app', 'Cover ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'enable_comment' => Yii::t('app', 'Enable Comment'),
            'status' => Yii::t('app', 'Privilege Setting'),
            'worth' => "Worth",
            'flag' => "Flag",
            'avatar' => "Avatar",
            'platform' => "Platform",

        ];
    }

    public function getPhotoCount()
    {
        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%weekly_content}}  WHERE album_id={$this->id}")
            ->queryScalar();
    }

    /**
     * This is invoked before the record is saved.
     * @return boolean whether the record should be saved.
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_by = Yii::$app->user->id;
                $this->created_at = time();
                $this->updated_at = time();
            }

            return true;
        } else {
            return false;
        }
    }

    public function getPhotos()
    {
        $query = new Query;
        $query->select('id, name, path')
            ->from('{{%weekly_content}}')
            ->where('album_id=:id', [':id' => $this->id]);
        $photos = Yii::$app->tools->Pagination($query);
        return [
            'photos' => $photos['result'],
            'pages' => $photos['pages']
        ];
    }

    public function getUser()
    {
        return Yii::$app->db
            ->createCommand("SELECT username, avatar FROM {{%user}} WHERE id={$this->created_by}")
            ->queryOne();
    }

    /**
     * 取得封面图片的地址
     * 本来只要一个相册id也是可以的，但为减少查询，故同时要 $id, $cover_id
     * @param integer $id 相册id
     * @param integer $cover_id 封面id
     */
    public function getCoverPhoto($id = null, $cover_id = null)
    {
        if ($id == null) {
            if ($this->cover_id == self::COVER_NONE) {
                if ($this->photoCount == 0) {
                    return '/images/pic-none.png';
                } else {
                    $path = $this->photos[0]['path'];
                }
            } else {
                $path = Yii::$app->db
                ->createCommand('SELECT path FROM {{%weekly_content}} WHERE id='.$this->cover_id)
                ->queryScalar();
            }
        } else {
            if ($cover_id == self::COVER_NONE) {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%weekly_content}} WHERE album_id='.$id)
                    ->queryScalar();
                if (empty($path)) {
                    return Yii::getAlias('@web') . '/images/pic-none.png';
                }
            } else {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%weekly_content}} WHERE id='.$cover_id)
                    ->queryScalar();
            }
        }
        return $path;
    }

    /**
     * 处理图片的上传
     */
    public function upload()
    {
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload('shisangirl',"uploads/bgadmin/$mkdir");
      /*  $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/weekly/', //存储文件夹
            'maxSize' => 2048 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        $up = new Uploader("file", $config, 'weekly'.$this->id);
        $info = $up->getFileInfo();*/

        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%weekly_content}}', [
            'name' => $this->title,
            'path' => $qiniu['key'], //存储路径
            'store_name' => $qiniu['hash'], //保存的名称
            'album_id' => $this->id,
            'created_at' => time(),
            'created_by'=>Yii::$app->user->id,
        ])->execute();
    }
    public function uploadf()
    {

        $qn = new QiniuUploader('photoimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload_water('shisangirl',"uploads/bgadmin/$mkdir");

        $weeklyContent = new WeeklyContent();
        $weeklyContent->name = !empty($this->title)?$this->title:"error";
        $weeklyContent->thumb = $qiniu['key'];
        $weeklyContent->path = $qiniu['key'];
        $weeklyContent->store_name = $qiniu['hash'];
        $weeklyContent->album_id = $this->id;
        $weeklyContent->created_at = time();
        $weeklyContent->created_by = 1;
        if($weeklyContent->save()){
            $data = array('id'=>$weeklyContent->id,'path'=>Yii::$app->params['shisangirl'].$qiniu['key']);
            return $data;
        }else{
            return var_dump($weeklyContent->errors);
        }

    }
    public function uploadw()
    {

        $qn = new QiniuUploader('weimaimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload('shisangirl',"uploads/bgadmin/weima/$mkdir");

        $weeklyContent = new WeeklyContent();
        $weeklyContent->name = !empty($this->title)?$this->title:"error";
        $weeklyContent->thumb = $qiniu['key'];
        $weeklyContent->path = $qiniu['key'];
        $weeklyContent->store_name = $qiniu['hash'];
        $weeklyContent->album_id = $this->id;
        $weeklyContent->created_at = time();
        $weeklyContent->status = 2;
        $weeklyContent->created_by = 1;
        if($weeklyContent->save()){
            $data = array('id'=>$weeklyContent->id,'path'=>Yii::$app->params['shisangirl'].$qiniu['key']);
            return $data;
        }else{
            return var_dump($weeklyContent->errors);
        }
    }

}
