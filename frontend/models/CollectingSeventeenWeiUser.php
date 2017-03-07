<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "pre_collecting_17_wei_user".
 *
 * @property integer $id
 * @property string $openid
 * @property string $address
 * @property integer $status
 */
class CollectingSeventeenWeiUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_collecting_17_wei_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['openid','status'], 'required'],
            [['status'], 'integer'],
            [['openid'], 'string', 'max' => 64],
            [['address'], 'string', 'max' => 128]
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
            'address' => 'Address',
            'status' => 'Status',
        ];
    }
}
