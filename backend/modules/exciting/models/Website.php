<?php

namespace backend\modules\exciting\models;
use common\Qiniu\QiniuUploader;
use Yii;
use backend\components\Uploader2;

/**
 * This is the model class for table "{{%website}}".
 *
 * @property string $website_id
 * @property string $title
 * @property integer $created_at
 * @property integer $updated_at
 */
class Website extends \yii\db\ActiveRecord
{

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%website}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title'], 'required'],
            [['created_at', 'updated_at'], 'integer'],
            [['title'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'website_id' => Yii::t('app', 'ID'),
            'title' => '标题',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
        ];
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }

    public function getPhotoCount()
    {
        return WebsiteContent::find()->where(['website_id'=>$this->website_id])->count();
    }

    public function getPhoto()
    {
        return $this->hasMany(WebsiteContent::className(), ['website_id' => 'website_id']);
    }

    public function getCoverPhoto($website_id)
    {
        $model = WebsiteContent::findOne(['website_id'=>$website_id]);

        if(!empty($model)){
            return $model->path;
        }else{
            return Yii::getAlias('@web') . '/images/pic-none.png';
        }
    }

    /**
     * @param int $type
     * @return array
     */
    public function upload($type=-1)
    {
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->website_id;
        $qiniu = $qn->upload('threadimages',"uploads/otherpick/$mkdir");
 /*       $config = [
            'savePath' => Yii::getAlias('@backend').'/web/images/website/', //存储文件夹
            'maxSize' => 4096 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg'],  //允许的文件格式
        ];
        $up = new Uploader2("file", $config, 'website'.$this->website_id,false);
        $info = $up->getFileInfo();*/

        if($type!=-1){
            $website_content = WebsiteContent::findOne($type);
            $website_content->path = $qiniu['key'];
            $website_content->update();
        }else{
            $website_content = new WebsiteContent();
            $website_content->website_id = $this->website_id;
            $website_content->path = $qiniu['key'];
            $website_content->name = $this->title;
            $website_content->save();
        }
        //存入数据库
    }
}
