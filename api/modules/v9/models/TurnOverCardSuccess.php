<?php

namespace api\modules\v9\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\db\Query;


/**
 * This is the model class for table "pre_turn_over_card_seccuse".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $beliked
 * @property integer $palace_id
 * @property integer $flag
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property User $beliked0
 */
class TurnOverCardSuccess extends ActiveRecord
{
    public $data;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_success';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'beliked'], 'required'],
            [['user_id', 'beliked', 'flag', 'created_at', 'updated_at'], 'integer']
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
            'beliked' => 'Beliked',
            'flag' => 'Flag',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLike()
    {
        return $this->hasOne(User::className(), ['id' => 'beliked']);
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = strtotime('today');
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

   public function fields()
    {
        $fields =[
            'id','user_id','like'=>'beliked',
            'flag',
            'created_at'=>function(){
                return date('Y年m月',$this->created_at);
            }
            ,'updated_at','info',
            'star'=>function(){

                $star = TurnOverCardJudge::find()->select('num')->where(['user_id'=>$this->beliked,'for_who'=>$this->user_id,'flag'=>0])->one();
                if(!empty($star['num'])){
                    return $star['num'];
                }else{
                    return 0;
                }
            }
        ];
        return $fields;

    }

    public function getInfo(){

        $user_id = $_GET['id'];
        if($user_id == $this->beliked){
            $user_id = $this->user_id;
        }else{
            $user_id = $this->beliked;
        }
        $info = (new Query())->select("u.id as user_id,username,nickname,sex,address,birthdate,avatar")
            ->from("{{%user}} as u")
            ->leftJoin('{{%user_profile}} as p ','u.id=p.user_id')
            ->where(['id'=>$user_id])
            ->one();
        if(empty($info['nickname'])){

            $info['nickname'] = $info['username'];
        }
        unset($info['username']);
        return $info;
    }
}
