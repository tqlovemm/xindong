<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_contact_ip_limits".
 *
 * @property integer $id
 * @property string $ip
 * @property integer $girl_rand
 * @property integer $boy_rand
 */
class ContactIpLimits extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_contact_ip_limits';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['girl_rand','boy_rand',], 'integer'],
            [['ip'], 'string', 'max' => 16]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ip' => 'Ip',
            'girl_rand' => 'Girl Rand',
            'boy_rand' => 'Boy Rand',
        ];
    }
}
