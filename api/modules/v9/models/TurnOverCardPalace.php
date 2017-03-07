<?php

namespace api\modules\v9\models;

use app\components\db\ActiveRecord;
use Yii;
use yii\db\Query;

/**
 * This is the model class for table "pre_turn_over_card_palace".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $like
 * @property integer $status
 * @property integer $flag
 * @property integer $is_del
 * @property integer $like_best
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property User $user
 * @property User $like0
 */
class TurnOverCardPalace extends ActiveRecord
{

    public $star = 0;
    public $match = 0;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_palace';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'like',], 'required'],
            [['user_id', 'like', 'status', 'flag', 'like_best', 'created_at', 'updated_at'], 'integer']
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
            'like' => 'Like',
            'status' => 'Status',
            'flag' => 'Flag',
            'like_best' => 'Like Best',
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
    public function getSuccess()
    {

        return $this->hasOne(TurnOverCardSuccess::className(), ['palace_id' => 'id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLike()
    {
        return $this->hasOne(User::className(), ['id' => 'like']);
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
        return [
            'id','user_id','like','status','flag','like_best','created_at','updated_at','info',
            'match' => function(){

                //查看like me 时
                $match = TurnOverCardSuccess::find()->where(['beliked'=>$this->like,'user_id'=>$this->user_id,'flag'=>0])->orWhere(['user_id'=>$this->like,'beliked'=>$this->user_id,'flag'=>0])->one();
                if($match['id']){
                    return 1;
                }else{
                    //不匹配
                    return 0;
                }



            }
        ];
    }

    public function getInfo(){

        $info = (new Query())->select("u.id as user_id,username,nickname,sex,address,birthdate,avatar")
            ->from("{{%user}} as u")
            ->leftJoin('{{%user_profile}} as p ','u.id=p.user_id')
            ->where(['id'=>$this->user_id])
            ->one();
        if(empty($info['nickname'])){

            $info['nickname'] = $info['username'];
        }
        unset($info['username']);
        return $info;
    }


}
