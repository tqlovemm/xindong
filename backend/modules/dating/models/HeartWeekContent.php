<?php
namespace backend\modules\dating\models;

use Yii;
use backend\components\Uploader2;
/**
 * This is the model class for table "{{%heartweek_content}}".
 *
 * @property string $id
 * @property string $album_id
 * @property string $name
 * @property string $thumb
 * @property string $content
 * @property string $path
 * @property string $store_name
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $is_cover
 * @property integer $style
 */
class HeartWeekContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%heartweek_content}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['album_id', 'created_at', 'created_by', 'is_cover','style'], 'integer'],
            [['name','content'], 'string'],
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
            'style' => '标题文字样式',
            'path' => Yii::t('app', 'Path'),
            'store_name' => Yii::t('app', 'Store Name'),
            'created_at' => Yii::t('app', 'Created At'),
            'created_by' => Yii::t('app', 'Created By'),
            'is_cover' => Yii::t('app', 'Is Cover'),
        ];
    }

    public function upload()
    {
        $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/heartweek/', //存储文件夹
            'maxSize' => 2048 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        $up = new Uploader2("file", $config, 'heartweek'.$this->id);

        $save_path =  Yii::getAlias('@web/uploads/heartweek/') . $this->created_by.'/';
        $info = $up->getFileInfo();

        //存入数据库
        Yii::$app->db->createCommand()->insert('{{%heartweek_slide_content}}', [
            'name' => $this->name,
            'path' => 'http://13loveme.com:82/'.$save_path . $info['name'], //存储路径
            'store_name' => $info['name'], //保存的名称
            'album_id' => $this->id,
            'created_at' => time(),
            'created_by'=>Yii::$app->user->id,
        ])->execute();
    }

}
