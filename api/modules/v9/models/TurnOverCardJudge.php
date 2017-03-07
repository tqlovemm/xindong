<?php

namespace api\modules\v9\models;

use app\components\db\ActiveRecord;
use Yii;

/**
 * This is the model class for table "pre_turn_over_card_judge".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $for_who
 * @property integer $num
 * @property integer $mark
 * @property integer $judge
 * @property integer $updated_at
 * @property integer $created_at
 */
class TurnOverCardJudge extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_turn_over_card_judge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'for_who','num','mark'], 'required'],
            [['flag', 'created_at', 'updated_at'], 'integer'],
            [['judge','mark'],'string','max'=>250],
            [['num'],'integer','min'=> 1,'max'=>5],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => '评论者',
            'for_who' => '被评论者',
            'num' => '获得的星星数量',
            'mark' => '标签',
            'judge' => '评论',
            'flag' => 'flag',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function fields()
    {
        return [
            'id','user_id','for_who','num','mark','for_who','judge','created_at'
        ];
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)){
            if($this->isNewRecord){
                $this->created_at = time();
                $this->updated_at = time();
            }else{
                $this->updated_at = time();
            }
            return true;
        }
        return false;
    }

    public function getUser()
    {

        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getWho()
    {

        return $this->hasOne(User::className(), ['id' => 'for_who']);
    }

}
