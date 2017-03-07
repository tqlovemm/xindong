<?php

namespace backend\modules\note\models;
use Yii;
use yii\db\Query;
use backend\components\Uploader2;

/**
 * This is the model class for table "{{%weichat_note}}".
 *
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $url
 * @property string $cover_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $enable_comment
 * @property integer $status
 */
class Note extends \yii\db\ActiveRecord
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
        return '{{%weichat_note}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','content'], 'required'],
            [['cover_id', 'created_at', 'updated_at', 'created_by', 'enable_comment', 'status'], 'integer'],

            [['title','content','url'], 'string', 'max' => 256]
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
            'content' => '内容',
            'url'=>'链接',
            'cover_id' => Yii::t('app', 'Cover ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'enable_comment' => Yii::t('app', 'Enable Comment'),
            'status' => Yii::t('app', 'Privilege Setting'),

        ];
    }

    public function getPhotoCount()
    {
        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%weichat_note_content}}  WHERE album_id={$this->id}")
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
                $this->status = 1;
                $this->cover_id = self::COVER_NONE;
            }

            return true;
        } else {
            return false;
        }
    }

    public function getPhotos()
    {
        $query = new Query;
        $query->select('id, name,thumb,store_name, path')
            ->from('{{%weichat_note_content}}')
            ->where('album_id=:id', [':id' => $this->id])->orderBy('created_at desc');
        $photos = Yii::$app->tools->Pagination($query);
        return [
            'photos' => $photos['result'],
            'pages' => $photos['pages']
        ];
    }
    public function getPhoto($id)
    {
        $query = new Query;
        $query->select('id, name, path')
            ->from('{{%weichat_note_content}}')
            ->where('album_id=:id', [':id' => $id]);
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
                ->createCommand('SELECT path FROM {{%weichat_note_content}} WHERE id='.$this->cover_id)
                ->queryScalar();
            }
        } else {
            if ($cover_id == self::COVER_NONE) {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%weichat_note_content}} WHERE album_id='.$id)
                    ->queryScalar();
                if (empty($path)) {
                    return Yii::getAlias('@web') . '/images/pic-none.png';
                }
            } else {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%weichat_note_content}} WHERE id='.$cover_id)
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
        $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/note/', //存储文件夹
            'maxSize' => 2048 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        $up = new Uploader2("file", $config, 'note'.$this->id,true);
        $info = $up->getFileInfo();

        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%weichat_note_content}}', [
            'name' => $this->title,
            'path' => 'http://13loveme.com:82'.Yii::getAlias('@web').'/uploads/note/' . Yii::$app->user->id . '/watermark/' . $info['name'], //存储路径
            'store_name' => $info['name'], //保存的名称
            'album_id' => $this->id,
            'created_at' => time(),
            'created_by'=>Yii::$app->user->id
        ])->execute();
    }
}
