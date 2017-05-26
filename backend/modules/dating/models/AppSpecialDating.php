<?php

namespace backend\modules\dating\models;

use api\modules\v9\models\AppSpecialDatingImages;
use common\Qiniu\QiniuUploader;
use Yii;

/**
 * This is the model class for table "pre_app_special_dating".
 *
 * @property integer $zid
 * @property string $p_info
 * @property string $h_info
 * @property string $introduce
 * @property integer $coin
 * @property integer $limit_count
 * @property integer $limit_vip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 * @property integer $sign_up_count
 * @property integer $authenticate
 * @property integer $tag_type
 * @property integer $contact_model
 * @property string $address
 * @property string $address_detail
 * @property string $weima
 * @property string $wechat
 *
 * @property AppSpecialDatingImages[] $appSpecialDatingImages
 */
class AppSpecialDating extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_special_dating';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['p_info', 'h_info'], 'required'],
            [['introduce'], 'string'],
            [['coin', 'limit_count', 'limit_vip', 'created_at', 'updated_at', 'status', 'sign_up_count', 'authenticate', 'tag_type', 'contact_model'], 'integer'],
            [['p_info', 'h_info', 'weima'], 'string', 'max' => 256],
            [['address', 'address_detail', 'wechat'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zid' => '编号',
            'p_info' => '关于我',
            'h_info' => '我想要',
            'introduce' => '简介',
            'weima' => '二维码',
            'wechat' => '微信号',
            'coin' => '需要节操币',
            'limit_count' => '限制报名数量',
            'limit_vip' => '限制报名会员等级',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'status' => '是否发布',
            'sign_up_count' => '报名数',
            'authenticate' => '是否认证',
            'tag_type' => '类型',
            'contact_model' => '联系方式',
            'address' => '地区',
            'address_detail' => '地区详情市街道等',
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
            $this->updated_at = time();
            return true;
        } else {
            return false;
        }
    }

    public function getPhotoCount()
    {
        return AppSpecialDatingImages::find()->where(['zid'=>$this->zid])->count();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(AppSpecialDatingImages::className(), ['zid' => 'zid'])->asArray();
    }


    /**
     * 处理图片的上传
     */
    public function upload()
    {
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->zid;
        $qiniu = $qn->upload('test02',"$mkdir");

        $model = new AppSpecialDatingImages();
        if(empty(AppSpecialDatingImages::findOne(['zid'=>$this->zid,'type'=>1]))){
            $model->type = 1;
        }
        $model->zid = $this->zid;
        $model->img_path = $qiniu['key'];
        $model->save();
    }
    /**
     * 处理微信二维码图片的上传
     */
    public function uploadw()
    {
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->zid.'weima';
        $qiniu = $qn->upload('test02',"$mkdir");

        $this->weima = $qiniu['key'];
        if(!$this->update()){
            var_dump($this->errors);
        }
    }


    public function getCoverPhoto()
    {
        $pre_url = Yii::$app->params['test'];
        $img = AppSpecialDatingImages::find()->where(['zid'=>$this->zid])->orderBy('pid asc')->asArray()->all();

        if(empty($img)){
            $path = Yii::getAlias('@web') . '/images/pic-none.png';
        }else{
            if(!empty(($model = AppSpecialDatingImages::findOne(['zid'=>$this->zid,'type'=>1])))){
                $path = $pre_url.$model->img_path;
            }else{
                $path = $pre_url.$img[0]['img_path'];
            }
        }

        return $path;
    }
}
