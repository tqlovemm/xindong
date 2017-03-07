<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pre_jiecao_coin_operation".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $value
 * @property string $reason
 * @property integer $type
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $where
 * @property string $number_info
 * @property integer $status
 * @property string $extra
 * @property string $handler
 * @property string $expire
 */
class JiecaoCoinOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    const STATUS = 10;
    public static function tableName()
    {
        return 'pre_jiecao_coin_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'value', 'reason', 'type', 'where', 'number_info','expire'], 'required'],
            [['user_id', 'value', 'type', 'created_at', 'updated_at', 'status','expire'], 'integer'],
            [['extra'], 'string'],
            [['reason'], 'string', 'max' => 512],
            [['where'], 'string', 'max' => 50],
            [['number_info', 'handler'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */

    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){

                $this->created_at = time();
                $this->updated_at = time();
                $this->status = self::STATUS;
                $this->handler = Yii::$app->user->identity->username;

            }else{

                $this->updated_at = time();
            }

            return true;
        }

        return false;
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'value' => 'Value',
            'reason' => 'Reason',
            'type' => 'Type',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'where' => 'Where',
            'number_info' => 'Number Info',
            'status' => 'Status',
            'extra' => 'Extra',
            'handler' => 'Handler',
            'expire' => 'Expire',
        ];
    }
}
