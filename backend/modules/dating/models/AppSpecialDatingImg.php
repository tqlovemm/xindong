<?php

namespace backend\modules\dating\models;

use Yii;

/**
 * This is the model class for table "pre_app_special_dating_images".
 *
 * @property integer $pid
 * @property integer $zid
 * @property integer $type
 * @property string $img_path
 *
 * @property AppSpecialDating $z
 */
class AppSpecialDatingImg extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_app_special_dating_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['zid', 'img_path'], 'required'],
            [['zid','type'], 'integer'],
            [['img_path'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'pid' => 'Pid',
            'zid' => 'Zid',
            'type' => 'Type',
            'img_path' => '图片路径',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getZ()
    {
        return $this->hasOne(AppSpecialDating::className(), ['zid' => 'zid']);
    }
}
