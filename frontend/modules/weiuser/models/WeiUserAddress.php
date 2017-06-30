<?php

namespace frontend\modules\weiuser\models;

use Yii;

/**
 * This is the model class for table "{{%wei_user_address}}".
 *
 * @property string $thirteen_platform_number
 * @property string $country
 * @property string $province
 * @property string $city
 * @property string $country_second
 * @property string $province_second
 * @property string $city_second
 * @property string $country_third
 * @property string $province_third
 * @property string $city_third
 */
class WeiUserAddress extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%wei_user_address}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['thirteen_platform_number'], 'required'],
            [['thirteen_platform_number'], 'string', 'max' => 32],
            [['country', 'province', 'city', 'country_second', 'province_second', 'city_second', 'country_third', 'province_third', 'city_third'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'thirteen_platform_number' => 'Thirteen Platform Number',
            'country' => 'Country',
            'province' => 'Province',
            'city' => 'City',
            'country_second' => 'Country Second',
            'province_second' => 'Province Second',
            'city_second' => 'City Second',
            'country_third' => 'Country Third',
            'province_third' => 'Province Third',
            'city_third' => 'City Third',
        ];
    }
}
