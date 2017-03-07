<?php

namespace frontend\modules\weixin\models;

use Yii;

/**
 * This is the model class for table "pre_vote_enter_user".
 *
 * @property integer $id
 * @property string $openid
 * @property string $nickname
 * @property integer $sex
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $headimgurl
 * @property string $unionid
 */
class VoteEnterUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_vote_enter_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid', 'nickname', 'sex', 'city', 'province', 'country', 'headimgurl', 'unionid'], 'required'],
            [['sex'], 'integer'],
            [['openid'], 'string', 'max' => 128],
            [['nickname', 'city', 'province', 'country'], 'string', 'max' => 50],
            [['headimgurl'], 'string', 'max' => 256],
            [['unionid'], 'string', 'max' => 250],
            [['openid'], 'unique'],
            [['unionid'], 'unique']
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
            'unionid' => 'Unionid',
        ];
    }
}
