<?php

namespace backend\modules\dating\models;
use backend\modules\weekly\models\WeeklyContent;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\db\Query;
use backend\components\Uploader2;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%weekly}}".
 *
 * @property string $id
 * @property string $title
 * @property string $title2
 * @property string $title3
 * @property string $content
 * @property string $introduction
 * @property string $expire
 * @property string $url
 * @property string $number
 * @property integer $cover_id
 * @property string $avatar
 * @property string $flag
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $full_time
 * @property integer $created_by
 * @property integer $enable_comment
 * @property integer $status
 * @property integer $worth
 * @property integer $platform
 */
class Dating extends \yii\db\ActiveRecord
{
    public $sort;
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
            [['title','content','url','expire'], 'required'],
            [['cover_id', 'created_at', 'updated_at', 'created_by', 'enable_comment', 'status','worth','expire','sort','platform','full_time'], 'integer'],
            [['title','title2','title3','content','url','number','avatar'], 'string', 'max' => 256],
            ['introduction','string', 'max' => 512],
            ['flag','string', 'max' => 32],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'number' => '妹子编号',
            'title' => '地区（请填写某某地区妹子，格式统一，如：安徽）',
            'title2' => '地区二（请填写某某地区妹子，格式统一，如：安徽）',
            'title3' => '地区三（请填写某某地区妹子，格式统一，如：安徽）',
            'content' => '妹子标签（不同标签之间请用【中文】逗号隔开）',
            'introduction' => '妹子文字介绍（可选）',
            'expire' => '过期时间（default 24 hour）',
            'url'=>'交友要求（不同标签之间请用【中文】逗号隔开）',
            'avatar'=>'密约头像',
            'cover_id' => Yii::t('app', 'Cover ID'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'created_by' => Yii::t('app', '创建人'),
            'enable_comment' => Yii::t('app', 'Enable Comment'),
            'status' => Yii::t('app', '状态码'),
            'worth'=>'价值',
            'flag'=>'标记',
            'platform'=>'是否公开',
            'full_time'=>'过期时间',

        ];
    }

    public function getPhotoCount()
    {
        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%weekly_content}}  WHERE album_id={$this->id}")
            ->queryScalar();
    }

    public function getCPhoto($id)
    {
        $avatar = Yii::$app->db
            ->createCommand("SELECT avatar FROM {{%weekly}} WHERE id=$id")
            ->queryScalar();
        if(!empty($avatar)){
            return $avatar;
        }else{
            return Yii::getAlias('@web') . '/images/pic-none.png';
        }
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_by = Yii::$app->user->id;
                if($this->sort==0){
                    $this->created_at = 1456243200;
                    $this->updated_at = 1456243200;
                }else{
                    $this->created_at = strtotime('today');
                    $this->updated_at = time();
                }
                $this->status = 2;
            }
            return true;
        } else {
            return false;
        }
    }

    /*联动查询*/
    public static function getUrl($type){

        $query = ArrayHelper::map(Dating::findAll(["status"=>2,'title'=>$type]), 'number', 'number');
        return $query;

    }

    public function getArea($id){

        return Yii::$app->db
            ->createCommand("SELECT title FROM {{%weekly}} WHERE status=2 and id=$id")
            ->queryOne();
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
    public function getPhoto($id,$type=0)
    {
        $query = new Query;
        $query->select('id, name, path')
            ->from('{{%weekly_content}}')
            ->where('album_id=:id', [':id' => $id])->andWhere(['status'=>$type]);
        $photos = Yii::$app->tools->Pagination($query);
        return [
            'photos' => $photos['result'],
            'pages' => $photos['pages']
        ];
    }
    public function getPhotoById($id)
    {
        $model = new DatingContent();
        return $model::find()->where(['album_id'=>$id])->asArray()->all();
    }
    public function getComment($id)
    {
        return Yii::$app->db
            ->createCommand("SELECT id,content,likes,created_at FROM {{%weekly_comment}} WHERE weekly_id='$id' order by id desc")
            ->queryAll();
    }

    public function getContent($id){

        return Yii::$app->db
            ->createCommand("SELECT * FROM {{%weekly}} WHERE id='$id'")
            ->queryOne();
    }
    public function getContentByNumber($number){

        return Yii::$app->db
            ->createCommand("SELECT * FROM {{%weekly}} WHERE number='$number'")
            ->queryOne();
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
     * @param string $type
     */
    public function upload($type='dating')
    {
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload_water('shisangirl',"uploads/dating/$mkdir");

        $status = ($type=='dating')?0:1;

        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%weekly_content}}', [
            'name' => $this->title,
            'path' => $qiniu['key'], //存储路径
            'store_name' => $qiniu['hash'], //保存的名称
            'album_id' => $this->id,
            'created_at' => time(),
            'created_by'=>Yii::$app->user->id,
            'status'=>$status
        ])->execute();
/*
        $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/dating/', //存储文件夹
            'maxSize' => 4096 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        $up = new Uploader2("file", $config, 'dating'.$this->id,true);

        $save_path =  Yii::getAlias('@web/uploads/dating/').'/watermark/';
        $info = $up->getFileInfo();

        $status = ($type=='dating')?0:1;

        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%weekly_content}}', [
            'name' => $this->title,
            'path' => 'http://13loveme.com:82'.$save_path . $info['name'], //存储路径
            'store_name' => $info['name'], //保存的名称
            'album_id' => $this->id,
            'created_at' => time(),
            'created_by'=>Yii::$app->user->id,
            'status'=>$status
        ])->execute();*/
    }
}
