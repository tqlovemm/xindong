<?php

namespace api\modules\v4\models;

use app\components\db\ActiveRecord;
use Yii;


/**
 * This is the model class for table "pre_recharge_record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $number
 * @property integer $subject
 * @property string $type
 * @property integer $giveaway
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class AppRechargeVerify extends ActiveRecord
{

    public $apple_receipt;
    public $level;
    const STATUS_ACTIVE = 10;

    public static function tableName()
    {
        return '{{%recharge_record}}';
    }

    public function rules()
    {
        return [
            [['user_id','number','apple_receipt','level'],'required'],
            [['subject','user_id','number','level','giveaway','created_at','updated_at'], 'integer'],
            [['apple_receipt','type'],'string'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'giveaway' => 'Giveaway',
            'number' => 'Money',
            'subject' => 'Subject',
            'type' => 'Type',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {

        return [

            'recharge_id'=>'id', 'user_id', 'subject', 'type','status', 'number', 'giveaway', 'updated_at', 'created_at',
        ];

    }

}


?>
