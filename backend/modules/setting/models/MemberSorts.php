<?php

namespace backend\modules\setting\models;

use common\Qiniu\QiniuUploader;
use frontend\modules\member\models\MemberSortImage;
use Yii;

/**
 * This is the model class for table "pre_member_sorts".
 *
 * @property integer $id
 * @property string $member_name
 * @property integer $giveaway
 * @property string $member_introduce
 * @property string $permissions
 * @property integer $price_1
 * @property integer $price_2
 * @property integer $price_3
 * @property integer $groupid
 * @property double $discount
 * @property integer $flag
 * @property integer $is_recommend
 * @property string $giveaway_qun
 */
class MemberSorts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_member_sorts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['member_name', 'member_introduce','permissions', 'price_1','price_2','price_3', 'discount'], 'required'],
            [['price_1','price_2','price_3','groupid','giveaway','flag','is_recommend'], 'integer'],
            [['discount'], 'number'],
            [['member_name'], 'string', 'max' => 50],
            [['member_introduce','permissions','giveaway_qun'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'member_name' => '会员名称',
            'giveaway' => '赠送节操币',
            'member_introduce' => '会员介绍',
            'permissions' => '会员权限',
            'price_1' => '北上广深浙苏价格',
            'price_2' => '新蒙青甘藏宁琼价格',
            'price_3' => '海外及其他地区价格',
            'discount' => '折扣',
            'groupid'=>'匹配用户组',
            'is_recommend'=>'是否为推荐',
            'giveaway_qun'=>'赠送群',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getImages()
    {
        return $this->hasMany(MemberSortImage::className(), ['sort_id' => 'id'])->where(['type'=>0])->orderBy("sort asc");
    }
    public function getImg()
    {
        return $this->hasMany(MemberSortImage::className(), ['sort_id' => 'id']);
    }

    public function getCover()
    {
        return $this->hasOne(MemberSortImage::className(), ['sort_id' => 'id'])->where(['type'=>1]);
    }

    public function getTop()
    {
        return $this->hasOne(MemberSortImage::className(), ['sort_id' => 'id'])->where(['type'=>2]);
    }

    public function upload()
    {
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$this->id;
        $qiniu = $qn->upload('threadimages',"uploads/member_sorts/$mkdir");

        $model = new MemberSortImage();
        $model->sort_id = $this->id;
        $model->img_path = $qiniu['key'];
        $model->save();
    }
}
