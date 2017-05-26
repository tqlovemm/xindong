<?php

namespace api\modules\v9\models;

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
 *
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
            [['p_info', 'h_info'], 'string', 'max' => 256],
            [['address', 'address_detail'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'zid' => '专属女生编号',
            'p_info' => '关于我',
            'h_info' => '我想要',
            'introduce' => '简介',
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

    public function fields()
    {
        return [
            'zid','coin', 'limit_count', 'limit_vip', 'created_at', 'sign_up_count', 'introduce',
            'p_info'=>function(){
                return explode(',',$this->p_info);
            },
            'h_info'=>function(){
                return explode(',',$this->h_info);
            },
            'address', 'address_detail',
            'tag_type'=>function(){
                if($this->tag_type==1){
                    return "HOT";
                }else{
                    return "";
                }
            },
            'contact_model'=>function(){
                if($this->contact_model==1){
                    return "微信号获取";
                }else{
                    return "其他方式";
                }
            },
            'authenticate'=>function(){
                if($this->authenticate==10){
                    return "已认证";
                }else{
                    return "未认证";
                }
            },
            'avatar'=>function(){
                if(Yii::$app->controller->action->id=="view"){
                    $images = AppSpecialDatingImages::findAll(['zid'=>$this->zid]);
                    return $images;
                }
                return $this->getCoverPhoto();
            },
            'chatImages'=>function(){

                return array();
            }
        ];
    }

    public function getImages()
    {
        return $this->hasMany(AppSpecialDatingImages::className(), ['zid' => 'zid'])->asArray()->orderBy('type desc');
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
