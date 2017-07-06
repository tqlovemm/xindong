<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_girl_flop_boy".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $is_like
 * @property integer $is_dislike
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class GirlFlopBoy extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_girl_flop_boy';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'is_like', 'is_dislike','status'], 'required'],
            [['user_id', 'is_like', 'is_dislike', 'created_at', 'updated_at', 'status'], 'integer']
        ];
    }

    public function fields()
    {
        return [
            'user_id', 'is_like', 'is_dislike'
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
            'is_like' => 'Is Like',
            'is_dislike' => 'Is Dislike',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'status' => 'Status',
        ];
    }
}
