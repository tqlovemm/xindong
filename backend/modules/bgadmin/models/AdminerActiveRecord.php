<?php

namespace backend\modules\bgadmin\models;

use backend\models\User;
use Yii;

/**
 * This is the model class for table "pre_adminer_active_record".
 *
 * @property integer $follow_id
 * @property integer $user_id
 * @property string $username
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $description
 * @property string $data
 * @property string $old_data
 * @property string $new_data
 * @property integer $type
 * @property integer $status
 *
 * @property User $user
 */
class AdminerActiveRecord extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_adminer_active_record';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'created_at', 'updated_at', 'status', 'type'], 'integer'],
            [['description', 'username', 'data', 'old_data', 'new_data'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'follow_id' => 'Follow ID',
            'user_id' => 'User ID',
            'username' => 'Username',
            'data' => 'Data',
            'old_data' => 'Old Data',
            'new_data' => 'New Data',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'description' => 'Description',
            'status' => 'Status',
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
                $this->updated_at = strtotime('today');
                $this->user_id = Yii::$app->user->id;
                $this->username = Yii::$app->user->identity->username;
                $this->status = 1;

            }else{

                $this->updated_at = time();
            }

            return true;
        }

        return false;
    }

    /**
     * @param $id
     * @return string
     */

    protected function getUsername($id){
        $user = User::findOne($id);
        return $user->username;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
