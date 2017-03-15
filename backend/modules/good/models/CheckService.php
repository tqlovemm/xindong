<?php

namespace backend\modules\good\models;

use backend\components\MyUpload;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\base\ErrorException;

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

        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);

        $exist = $this->findOne($this->id);
        if(!empty($exist['avatar'])){
            try{
                $qn->delete('threadimages',$exist['avatar']);
            }catch (ErrorException $e){

                throw new ErrorException();
            }

        }
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload('threadimages',"uploads/weixin_avatar/$mkdir");
        $this->avatar = $qiniu['key'];
        $this->save();
    }
}
