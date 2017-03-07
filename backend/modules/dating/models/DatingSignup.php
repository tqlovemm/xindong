<?php

namespace backend\modules\dating\models;

use Yii;

/**
 * This is the model class for table "pre_dating_signup".
 *
 * @property integer $id
 * @property string $msg
 * @property integer $user_id
 * @property integer $status
 * @property string $like_id
 * @property integer $type
 * @property string $extra
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 */
class DatingSignup extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_dating_signup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['msg', 'user_id', 'status', 'like_id', 'extra', 'created_at', 'updated_at'], 'required'],
            [['user_id', 'status', 'type', 'created_at', 'updated_at'], 'integer'],
            [['extra'], 'string'],
            [['msg'], 'string', 'max' => 256],
            [['like_id'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'msg' => 'Msg',
            'user_id' => 'User ID',
            'status' => 'Status',
            'like_id' => 'Like ID',
            'type' => 'Type',
            'extra' => 'Extra',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
