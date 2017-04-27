<?php

namespace mdm\admin\models;

use Yii;

/**
 * This is the model class for table "pre_admin_change_password_log".
 *
 * @property integer $id
 * @property integer $created_by
 * @property integer $created_at
 */
class AdminChangePassword extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_admin_change_password_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_by', 'created_at'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'created_by' => 'Created By',
            'created_at' => 'Created At',
        ];
    }


    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_by = Yii::$app->user->id;
            }
            $this->created_at = time();
            return true;
        }
        return false;
    }

}
