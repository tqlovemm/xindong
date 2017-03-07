<?php

namespace frontend\modules\weixin\models;

use Yii;

/**
 * This is the model class for table "pre_send_mobile_code".
 *
 * @property integer $id
 * @property string $ip
 * @property string $mobile
 * @property integer $created_at
 * @property integer $updated_at
 */
class SendMobileCode extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_send_mobile_code';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip', 'mobile'], 'required'],
            [['created_at','updated_at'], 'integer'],
            [['ip'], 'string', 'max' => 32],
            [['mobile'], 'string', 'max' => 16]
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
            'mobile' => 'Mobile',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = strtotime('today');
                $this->updated_at = time();
            }
            return true;
        } else {
            return false;
        }
    }
}
