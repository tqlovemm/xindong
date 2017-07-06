<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_girl_flop_record".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class GirlFlopRecord extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_girl_flop_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id',], 'required'],
            [['user_id', 'created_at', 'updated_at'], 'integer']
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
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
