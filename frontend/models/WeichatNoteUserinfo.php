<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_weichat_note_userinfo".
 *
 * @property integer $id
 * @property integer $participantid
 * @property integer $noteid
 * @property string $openid
 * @property string $nickname
 * @property integer $sex
 * @property string $language
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $headimgurl
 * @property integer $subscribe
 * @property integer $subscribe_time
 * @property string $unionid
 * @property integer $type
 * @property integer $status
 */
class WeichatNoteUserinfo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_weichat_note_userinfo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['noteid', 'sex', 'subscribe', 'subscribe_time','participantid','status','type'], 'integer'],
            [['openid', 'unionid'], 'string', 'max' => 128],
            [['nickname', 'city', 'province', 'country', 'language'], 'string', 'max' => 50],
            [['headimgurl'], 'string', 'max' => 256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'noteid' => 'Noteid',
            'participantid' => 'Prticipantid',
            'openid' => 'Openid',
            'subscribe' => 'Subscribe',
            'subscribe_time' => 'Subscribe_time',
            'unionid' => 'Unionid',
            'status' => 'Status',
            'type' => 'Type',
            'language' => 'Language',
            'nickname' => 'Nickname',
            'sex' => 'Sex',
            'city' => 'City',
            'province' => 'Province',
            'country' => 'Country',
            'headimgurl' => 'Headimgurl',
        ];
    }
}
