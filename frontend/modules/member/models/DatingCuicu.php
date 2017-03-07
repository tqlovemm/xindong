<?php

namespace frontend\modules\member\models;

use frontend\models\RechargeRecord;
use Yii;

/**
 * This is the model class for table "pre_dating_cuicu".
 *
 * @property integer $id
 * @property integer $ccid
 * @property integer $user_id
 * @property integer $updated_at
 * @property integer $created_at
 * @property integer $type
 * @property integer $status
 * @property string $handler
 * @property string $reason
 */
class DatingCuicu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_dating_cuicu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ccid'], 'required'],
            [['ccid', 'user_id', 'created_at','updated_at', 'type', 'status'], 'integer'],
            [['handler'], 'string','max'=>16],
            [['reason'], 'string','max'=>256]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ccid' => 'Ccid',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'status' => 'Status',
            'handler' => 'Handler',
            'reason' => 'Reason',
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord) {
                $this->created_at = time();
                $this->updated_at = time();
                $this->user_id = Yii::$app->user->id;
            }else{
                $this->updated_at = time();
                $this->handler = Yii::$app->user->identity->username;
            }
            return true;
        } else {
            return false;
        }
    }

    public function getRecord()
    {
        return $this->hasOne(RechargeRecord::className(), ['id' => 'ccid']);
    }
}
