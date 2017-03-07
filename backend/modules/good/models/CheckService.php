<?php

namespace backend\modules\good\models;

use backend\components\MyUpload;
use Yii;

/**
 * This is the model class for table "pre_check_service".
 *
 * @property integer $id
 * @property string $number
 * @property string $avatar
 * @property string $nickname
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 */
class CheckService extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_check_service';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['number',], 'required'],
            [['number','nickname','avatar'],'string'],
            [[ 'flag', 'created_at', 'updated_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'number' => 'Number',
            'nickname' => 'nickname',
            'avatar' => 'avatar',
            'flag' => 'Flag',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
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
            'savePath' =>   Yii::getAlias('@webroot/uploads/weixin_avatar'),
            'maxSize'   =>  5000,
            'allowFiles'    =>  ['.jpg','.png','jpeg'],
        ];

        $up = new MyUpload('file',$config,'');
        $info = $up->getFileInfo();

        $path = "http://13loveme.com:82".Yii::getAlias('@web/uploads/weixin_avatar/').$info['name'];
        $exist = $this->findOne($this->id);
        if(!empty($exist['avatar'])){
            $delPath = explode("http://13loveme.com:82",$exist['avatar']);
            $delPath = Yii::getAlias('@webroot').$delPath[1];
            unlink($delPath);
        }
        $this->avatar = $path;
        $this->save();

    }
}
