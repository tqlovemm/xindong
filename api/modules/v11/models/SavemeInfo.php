<?php

namespace api\modules\v11\models;

use Yii;
use app\components\db\ActiveRecord;

/**
 * This is the model class for table "pre_saveme_apply".
 *
 * @property integer $id
 * @property integer $saveme_id
 * @property integer $apply_uid
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $status
 */
class SavemeInfo extends ActiveRecord
{
    public $_user;
    public $is_overdue;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%saveme_apply}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['saveme_id', 'apply_uid', 'status'], 'required'],
            [['saveme_id', 'apply_uid', 'created_at', 'updated_at', 'status', 'type'], 'integer']
        ];
    }

    public function fields(){
        $this->_user = Yii::$app->db->createCommand("select username,nickname,avatar,sex,groupid from {{%user}} where id=$this->apply_uid")->queryOne();
        $saveme = Yii::$app->db->createCommand("select end_time from {{%saveme}} where id=$this->saveme_id")->queryOne();
        if($saveme['end_time'] < time()){
            $this->is_overdue = 1;
        }else{
            $this->is_overdue = 2;
        }
        return [
            'apply_id'=>'id','saveme_id', 'apply_uid', 'created_at','updated_at', 'status','nickname'=>function(){if($this->_user['nickname']){return $this->_user['nickname'];}else{return $this->_user['username'];};},'level'=>function(){return $this->_user['groupid'];},'avatar'=>function(){return $this->_user['avatar'];},'is_overdue'=>function(){return $this->is_overdue;},'sex'=>function(){return $this->_user['sex'];},'address',
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'saveme_id' => 'Saveme ID',
            'apply_uid' => '申请人id',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'type' => 'Type',
            'status' => 'Status',
        ];
    }
    public function getAddress(){
        $user = Yii::$app->db->createCommand("select address from {{%user_profile}} where user_id=$this->apply_uid")->queryOne();

        return $user['address'];
    }
}
