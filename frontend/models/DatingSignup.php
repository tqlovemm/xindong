<?php

namespace frontend\models;

use Yii;
use app\modules\user\models\User;

/**
 * This is the model class for table "pre_dating_signup".
 *
 * @property integer $id
 * @property string $msg
 * @property integer $user_id
 * @property integer $type
 * @property integer $status
 * @property string $like_id
 * @property string $worth
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $extra
 * @property string $area
 * @property string $avatar
 *
 * @property User $like
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
            [['user_id', 'status', 'type', 'created_at', 'updated_at','worth'], 'integer'],
            [['msg', 'extra', 'like_id','avatar','area'], 'string', 'max' => 256]
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
            'worth' => 'Worth',
            'extra' => 'Extra',
            'avatar' => 'Avatar',
            'area' => 'Area',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {

                $this->created_at = time();
                $this->updated_at = time();
                $this->user_id = Yii::$app->user->id;
            }
            return true;
        } else {
            return false;
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
