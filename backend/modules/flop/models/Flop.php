<?php

namespace backend\modules\flop\models;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\db\Query;
use backend\components\UploadThumb;

/**
 * This is the model class for table "{{%flop}}".
 *
 * @property string $id
 * @property string $area
 * @property string $content
 * @property string $cover_id
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $created_by
 * @property integer $status
 * @property integer $sex
 */
class Flop extends \yii\db\ActiveRecord
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
        return '{{%flop}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['area','sex'], 'required'],
            [['cover_id', 'created_at', 'updated_at', 'created_by','status','sex'], 'integer'],

            [['area','content'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'area' => '地区',
            'content' => '内容',
            'sex'=>'性别',
            'cover_id' => Yii::t('app', 'Cover ID'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'created_by' => Yii::t('app', 'Created By'),
            'status' => Yii::t('app', 'Privilege Setting'),

        ];
    }

    public function getPhotoCount()
    {
        return Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%flop_content}}  WHERE flop_id={$this->id}")
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
        $query->select('id,area,number, content,path,is_cover')
            ->from('{{%flop_content}}')
            ->where('flop_id=:id', [':id' => $this->id])->orderBy('updated_at asc')->addOrderBy('created_at desc');
        $photos = Yii::$app->tools->Pagination($query);
        return [
            'photos' => $photos['result'],
            'pages' => $photos['pages']
        ];
    }
    public function getPhoto($id)
    {
        $query = new Query;
        $query->select('id,area,number, content,path')
            ->from('{{%flop_content}}')
            ->where('flop_id=:id', [':id' => $id]);
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
                ->createCommand('SELECT path FROM {{%flop_content}} WHERE id='.$this->cover_id)
                ->queryScalar();
            }
        } else {
            if ($cover_id == self::COVER_NONE) {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%flop_content}} WHERE flop_id='.$id)
                    ->queryScalar();
                if (empty($path)) {
                    return Yii::getAlias('@web') . '/images/pic-none.png';
                }
            } else {
                $path = Yii::$app->db
                    ->createCommand('SELECT path FROM {{%flop_content}} WHERE id='.$cover_id)
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
        $mkdir = date('Y').'/'.date('m').'/'.date('d');
        $qiniu = $qn->upload('tqlmm',"uploads/flop/$mkdir/$this->id");

/*        $config = [
            'savePath' => Yii::getAlias('@backend').'/web/uploads/flop/', //存储文件夹
            'maxSize' => 2048 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.gif' , '.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];
        $up = new UploadThumb("file", $config, 'flop_'.$this->id,true);
        $info = $up->getFileInfo($this->sex);*/

        //存入数据库
         Yii::$app->db->createCommand()->insert('{{%flop_content}}', [
            'area' => $this->area,
            'number'=>$qiniu['hash'],
            'path' => $qiniu['key'], //存储路径
            'store_name' => $qiniu['hash'], //保存的名称
            'content'=>$qiniu['key'],
            'flop_id' => $this->id,
            'sex' => $this->sex,
            'created_at' => time(),
            'created_by'=>Yii::$app->user->id,
        ])->execute();

    }
}
