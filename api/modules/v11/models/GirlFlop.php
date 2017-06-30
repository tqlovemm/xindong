<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_girl_flop".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $flop_userid
 * @property integer $flop_type
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class GirlFlop extends ActiveRecord
{
    public $username;
    public $address;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_girl_flop';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'flop_userid', 'flop_type', 'status'], 'required'],
            [['user_id', 'flop_userid', 'flop_type', 'created_at', 'updated_at', 'status'], 'integer']
        ];
    }

    public function fields()
    {
        return [
            'user_id', 'flop_userid', 'flop_type',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'flop_userid' => 'Flop Userid',
            'flop_type' => 'Flop Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
