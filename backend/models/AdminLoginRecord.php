<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pre_admin_login_record".
 *
 * @property integer $id
 * @property integer $created_at
 * @property integer $created_by
 * @property string $web_id
 * @property string $hostname
 */
class AdminLoginRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_admin_login_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'created_by'], 'integer'],
            [['web_id', 'hostname'], 'string', 'max' => 32]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_at' => 'Created At',
            'created_by' => 'Created By',
            'web_id' => 'Web ID',
            'hostname' => 'Hostname',
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->created_by = Yii::$app->user->id;
            }
            return true;
        }
        return false;
    }
}
