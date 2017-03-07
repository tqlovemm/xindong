<?php

namespace backend\modules\good\models;

use backend\components\MyUpload;
use Yii;

/**
 * This is the model class for table "pre_hx_group".
 *
 * @property integer $id
 * @property integer $g_id
 * @property string $avatar
 * @property string $thumb
 * @property string $groupname
 * @property string $owner
 * @property string $affiliations
 * @property integer $created_at
 * @property integer $updated_at
 */
class HxGroup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_hx_group';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'created_at', 'updated_at','affiliations'], 'integer'],
            [['avatar','g_id','thumb','groupname','owner'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'g_id' => 'G ID',
            'avatar' => 'Avatar',
            'thumb' => 'thumb',
            'affiliations' => 'affiliations',
            'groupname' => 'groupname',
            'owner' => 'owner',
            //'created_at' => 'Created At',
            //'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

    public function upload(){

        $config = [
            'savePath'  =>  Yii::getAlias('@webroot/uploads/group'),
            'maxSize'   =>  5000,
            'allowFiles'    =>  ['.jpg','.jpeg','.png'],
        ];

        $up = new  MyUpload('file',$config,'',true);
        $info = $up->getFileInfo();

        $path = "http://13loveme.com:82".Yii::getAlias('@web/uploads/group/');
        $thumb = $path.'thumb/'.$info['name'];

        //删除旧图片
        $exist = $this->findOne(['id'=>$this->id]);
        if(!empty($exist['avatar'])){
            $avatar = explode('http://13loveme.com:82',$exist['avatar']);
            $ava_thum=  explode('http://13loveme.com:82',$exist['thumb']);
            $web_path = Yii::getAlias('@webroot');
            unlink($web_path.$avatar[1]);
            unlink($web_path.$ava_thum[1]);
        }
        $this->avatar = $path.$info['name'];
        $this->thumb = $thumb;
        $this->save();

    }
}
