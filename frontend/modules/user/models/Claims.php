<?php
/**
 * Created by PhpStorm.
 * User: tqmm
 * Date: 15-11-17
 * Time: 下午5:06
 */

namespace app\modules\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\base\Model;
/**
 * This is the model class for table "{{%user_claims}}".
 *
 * @property integer $id
 * @property string $created_by
 * @property string $claims_to
 * @property integer $created_at
 * @property string $content
 * @property string $title
 * @property string $file
 */
class Claims extends ActiveRecord
{


    public static function tableName()
    {
        return '{{%user_claims}}';
    }

    public function rules()
    {
        return[

            [['title','content','claims_to','file'],'required'],
            [['title','content','claims_to'], 'string'],
            [['claims_to','title'], 'string', 'max' => 255],
            [['created_by'], 'string', 'max' => 255],
            [['created_at'], 'integer'],
            [['file'], 'file','skipOnEmpty' => true, 'extensions' => 'png, jpg ,mp3'],

        ];
    }

    public function attributeLabels()
    {
        return [
            'claims_to' => '投诉对象',
            'title' => '标题',
            'content' => '内容',
            'created_by'=>Yii::t('app','Created By'),
            'created_at'=>Yii::t('app','Created At'),
            'file' =>'图片',
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            Yii::setAlias('@upload2', '@backend/web/uploads/claims/');
            $path = Yii::$app->user->identity->username.time().rand(999,10000) . '.' . $this->file->extension;

            $this->file->saveAs(Yii::getAlias('@upload2').$path );

            return $path;

        } else {
            return false;
        }
    }


}