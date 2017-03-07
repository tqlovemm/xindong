<?php

namespace backend\modules\setting\models;

use Yii;

/**
 * This is the model class for table "pre_send_url_to_user".
 *
 * @property integer $id
 * @property string $weichat
 * @property string $number
 * @property string $level
 * @property string $description
 * @property string $rand
 * @property string $url
 * @property integer $status
 * @property integer $jiecao_coin
 * @property integer $created_at
 * @property integer $read
 */
class SendUrlToUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_send_url_to_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['weichat','number','level','jiecao_coin'], 'required'],
            [['status', 'created_at', 'read','jiecao_coin'], 'integer'],
            [['weichat','rand', 'url','number','level'], 'string', 'max' => 512],
            [['description'], 'string', 'max' => 256]
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            if ($this->isNewRecord) {

                $this->created_at = time();

            }

            return true;

        } else {

            return false;

        }
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'weichat' => 'Weichat',
            'description' => 'Description',
            'rand' => 'Rand',
            'url' => 'Url',
            'status' => 'Status',
            'created_at' => 'Created At',
            'read' => 'Read',
        ];
    }
}
