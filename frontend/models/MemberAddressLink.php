<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "pre_member_address_link".
 *
 * @property integer $id
 * @property string $areaname
 * @property integer $parentid
 * @property string $shortname
 * @property integer $areacode
 * @property integer $zipcode
 * @property string $pinyin
 * @property string $lng
 * @property string $lat
 * @property integer $level
 * @property string $position
 * @property integer $sort
 */
class MemberAddressLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_member_address_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'areaname', 'parentid', 'level', 'position'], 'required'],
            [['id', 'parentid', 'areacode', 'zipcode', 'level', 'sort'], 'integer'],
            [['areaname', 'shortname'], 'string', 'max' => 50],
            [['pinyin'], 'string', 'max' => 100],
            [['lng', 'lat'], 'string', 'max' => 20],
            [['position'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'areaname' => 'Areaname',
            'parentid' => 'Parentid',
            'shortname' => 'Shortname',
            'areacode' => 'Areacode',
            'zipcode' => 'Zipcode',
            'pinyin' => 'Pinyin',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'level' => 'Level',
            'position' => 'Position',
            'sort' => 'Sort',
        ];
    }
}
