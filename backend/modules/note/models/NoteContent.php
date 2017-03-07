<?php
namespace backend\modules\note\models;

use Yii;
use backend\components\Uploader2;
use yii\db\Query;

/**
 * This is the model class for table "{{%weekly_content}}".
 *
 * @property string $id
 * @property string $album_id
 * @property string $name
 * @property string $thumb
 * @property string $path
 * @property string $store_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_cover
 */
class NoteContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%weichat_note_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'name', 'thumb', 'path', 'created_at', 'created_by'], 'required'],
            [['album_id', 'created_at', 'created_by', 'is_cover'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['thumb', 'path', 'store_name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'album_id' => Yii::t('app', 'Album ID'),
            'name' => Yii::t('app', 'Name'),
            'thumb' => Yii::t('app', 'Thumb'),
            'path' => Yii::t('app', 'Path'),
            'store_name' => Yii::t('app', 'Store Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'is_cover' => Yii::t('app', 'Is Cover'),
        ];
    }

    public function getPhotos()
    {
        $query = (new Query())->select('id, name, path')->from('{{%weichat_note_content_detail}}')->where('noteid=:id', [':id' => $this->id])->all();

        return $query;
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
        Yii::$app->db->createCommand()->insert('{{%weichat_note_content_detail}}', [
            'name' => $this->name,
            'path' => 'http://13loveme.com:82'.Yii::getAlias('@web').'/uploads/note/' . Yii::$app->user->id . '/watermark/' . $info['name'], //存储路径
            'store_name' => $this->name, //保存的名称
            'noteid' => $this->id,
            'created_at' => time(),
            'created_by'=>Yii::$app->user->id
        ])->execute();
    }
}
