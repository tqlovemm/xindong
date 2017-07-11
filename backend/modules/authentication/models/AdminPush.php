<?php

namespace backend\modules\authentication\models;

use Yii;

/**
 * This is the model class for table "pre_admin_push".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $status
 */
class AdminPush extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_admin_push';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'status'], 'integer']
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
            'status' => 'Status',
        ];
    }
}
