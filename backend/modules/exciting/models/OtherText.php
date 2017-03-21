<?php

namespace backend\modules\exciting\models;
use backend\components\Uploader;
use common\Qiniu\QiniuUploader;
use Yii;
use backend\components\Uploader2;

/**
 * This is the model class for table "{{%all_other_text}}".
 *
 * @property string $tid
 * @property string $title
 * @property string $content
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $type
 * @property integer $status
 */
class OtherText extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%all_other_text}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','content'], 'required'],
            [['type', 'created_at', 'updated_at', 'status'], 'integer'],
            [['title','content'], 'string', 'max' => 128],
            [['created_by'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tid' => 'TID',
            'title' => 'Title',
            'content' => 'Content',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'created_by' => 'Created By',
            'type' => 'Type',
            'status' => 'Status',

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
                $this->created_by = Yii::$app->user->identity->username;
                $this->created_at = time();
            }
            $this->updated_at = time();
            return true;
        } else {
            return false;
        }
    }

    public function getPhotoCount()
    {
        return OtherTextPic::find()->where(['tid'=>$this->tid])->count();
    }

    public function getPic()
    {
        $query = OtherTextPic::find()->asArray()->where(['tid'=>$this->tid]);
        $photos = Yii::$app->tools->Pagination($query);
        return [
            'photos' => $photos['result'],
            'pages' => $photos['pages']
        ];

    }

    public function getCoverPhoto($tid)
    {
        $model = OtherTextPic::findOne(['tid'=>$tid]);
        if(!empty($model)){
            return $model->pic_path;
        }else{
            return Yii::getAlias('@web') . '/images/pic-none.png';
        }
    }

    /**
     * @param null $dir
     * @return array
     * 处理图片的上传
     */

    public function upload()
    {
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->tid;
        $qiniu = $qn->upload_water('threadimages',"uploads/otherpick/$mkdir");
     /*   $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/otherpick/'.$this->type.'/', //存储文件夹
            'maxSize' => 4096 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg'],  //允许的文件格式
        ];
        $up = new Uploader2("file", $config, 'otherpick_'.$this->tid,true);
        $info = $up->getFileInfo();*/

        //存入数据库
        $pic = new OtherTextPic();
        $pic->tid = $this->tid;
        $pic->name = $this->title;
        $pic->content = $this->title;
        $pic->pic_path = $qiniu['key'];
        $pic->type = $this->type;
        $pic->save();

    }
}
