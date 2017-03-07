<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_dinyue_weichat_userinfo".
 *
 * @property integer $id
 * @property string $openid
 * @property string $nickname
 * @property integer $sex
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $headimgurl
 * @property integer $subscribe
 * @property integer $subscribe_time
 * @property string $unionid
 */
class DinyueWeichatUserinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_dinyue_weichat_userinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'sex', 'subscribe', 'subscribe_time'], 'integer'],
            [['openid'], 'string', 'max' => 128],
            [['nickname', 'city', 'province', 'country'], 'string', 'max' => 50],
            [['headimgurl'], 'string', 'max' => 256],
            [['unionid'], 'string', 'max' => 250]
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
            'sex' => 'Sex',
            'city' => 'City',
            'province' => 'Province',
            'country' => 'Country',
            'headimgurl' => 'Headimgurl',
            'subscribe' => 'Subscribe',
            'subscribe_time' => 'Subscribe Time',
            'unionid' => 'Unionid',
        ];
    }
}
