<?php

namespace api\modules\v9\models;

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
class AppSpecialDatingImages extends \yii\db\ActiveRecord
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
    public function fields()
    {
        return [
            'pid','zid','type',
            'img_path'=>function(){
                $pre_url = Yii::$app->params['test'];
                return $pre_url.$this->img_path;
            }
        ];
    }
}
