<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "pre_admin_check".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $type
 * @property integer $status
 * @property integer $coin
 * @property integer $pre_coin
 * @property integer $vip
 * @property integer $pre_vip
 * @property integer $checker
 * @property integer $updated_at
 */
class AdminCheck extends \yii\db\ActiveRecord
{
    /*type=1,添加节操币，type=2会员升级*/
    /*status=1,未审核，status=2审核同意，status=3审核拒绝*/
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_admin_check';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'created_by','created_at', 'type', 'status','coin','vip','checker','updated_at','pre_coin','pre_vip'], 'integer']
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
            'created_by' => 'Created By',
            'type' => 'Type',
            'status' => 'Status',
            'coin' => 'coin',
            'pre_coin' => 'pre_coin',
            'vip' => 'vip',
            'pre_vip' => 'pre_vip',
            'checker' => 'checker',
            'updated_at' => 'updated_at',
        ];
    }
    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->created_by = Yii::$app->user->id;
            }
            $this->updated_at = time();
            return true;
        }
        return false;
    }
}
