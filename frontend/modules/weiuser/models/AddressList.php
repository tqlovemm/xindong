<?php

namespace frontend\modules\weiuser\models;

use Yii;

/**
 * This is the model class for table "{{%address_list}}".
 *
 * @property string $code
 * @property string $country_code
 * @property string $region_name_e
 * @property string $region_name_c
 * @property string $level
 * @property string $upper_region
 */
class AddressList extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%address_list}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code', 'country_code', 'level', 'upper_region'], 'string', 'max' => 20],
            [['region_name_e'], 'string', 'max' => 80],
            [['region_name_c'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'code' => 'Code',
            'country_code' => 'Country Code',
            'region_name_e' => 'Region Name E',
            'region_name_c' => 'Region Name C',
            'level' => 'Level',
            'upper_region' => 'Upper Region',
        ];
    }
}
