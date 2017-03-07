<?php

namespace frontend\modules\weixin\models;

use app\components\Uploader;
use Yii;

/**
 * This is the model class for table "pre_vote_sign_info".
 *
 * @property integer $id
 * @property string $openid
 * @property string $headimgurl
 * @property string $nickname
 * @property string $number
 * @property string $declaration
 * @property integer $sex
 * @property string $extra
 * @property integer $vote_count
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 *
 * @property VoteSignImg[] $voteSignImgs
 */
class VoteSignInfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_vote_sign_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid'], 'required'],
            [['sex', 'vote_count', 'created_at', 'updated_at', 'status'], 'integer'],
            [['openid'], 'string', 'max' => 64],
            [['number'], 'string', 'max' => 32],
            [['declaration', 'extra','nickname','headimgurl'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'headimgurl' => 'Head Img Url',
            'number' => 'Number',
            'declaration' => 'Declaration',
            'sex' => 'Sex',
            'extra' => 'Extra',
            'vote_count' => 'Vote Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVoteSignImgs()
    {
        return $this->hasMany(VoteSignImg::className(), ['info_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImg()
    {
        return $this->hasOne(VoteSignImg::className(), ['info_id' => 'id']);
    }

    public function upload()
    {
        $config = [
            'savePath' => Yii::getAlias('@webroot/uploads/vote/01/'), //存储文件夹
            'maxSize' => 5000 ,//允许的文件最大尺寸，单位KB
            'allowFiles' => ['.png' , '.jpg' , '.jpeg' , '.bmp'],  //允许的文件格式
        ];

        $up = new Uploader("photoimg", $config, $this->id);


        $save_path =  Yii::getAlias('@web/uploads/vote/01/');

        $info = $up->getFileInfo();

        //存入数据库

        $save_img = new VoteSignImg();
        $save_img->info_id = $this->id;
        $save_img->img = $save_path.$info['name'];
        $save_img->save();

        $data = array('id'=>$this->id,'path'=>$save_path.$info['name']);
        return $data;
    }
}
