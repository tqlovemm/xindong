<?php

namespace frontend\modules\weiuser\models;

use Yii;

/**
 * This is the model class for table "{{%wei_user_info}}".
 *
 * @property string $openid
 * @property string $nickname
 * @property string $headimgurl
 * @property integer $sex
 * @property integer $province
 * @property integer $city
 * @property integer $province_second
 * @property integer $city_second
 * @property integer $province_third
 * @property integer $city_third
 * @property string $thirteen_platform_number
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class WeiUserInfo extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DELETED = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wei_user_info}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid'], 'required'],
            [['sex', 'province', 'city', 'province_second', 'city_second', 'province_third', 'city_third', 'created_at', 'updated_at', 'status'], 'integer'],
            [['openid'], 'string', 'max' => 64],
            [['nickname', 'thirteen_platform_number'], 'string', 'max' => 32],
            [['headimgurl'], 'string', 'max' => 256],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'openid' => 'Openid',
            'nickname' => 'Nickname',
            'headimgurl' => 'Headimgurl',
            'sex' => 'Sex',
            'province' => 'Province',
            'city' => 'City',
            'province_second' => 'Province Second',
            'city_second' => 'City Second',
            'province_third' => 'Province Third',
            'city_third' => 'City Third',
            'thirteen_platform_number' => 'Thirteen Platform Number',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }

    public static function findByOpenid($openid)
    {
        return static::findOne(['openid' => $openid, 'status' => self::STATUS_ACTIVE]);
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){

            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }
            $this->updated_at = time();

            return true;
        }
    }

    public function getArea()
    {
        return $this->hasOne(WeiUserAddress::className(), ['thirteen_platform_number' => 'thirteen_platform_number']);
    }


}
