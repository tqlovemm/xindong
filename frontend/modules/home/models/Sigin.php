<?php

namespace app\modules\home\models;

use Yii;

/**
 * This is the model class for table "{{%user_sigin}}".
 *
 * @property integer $user_id
 * @property integer $sigindata
 * @property integer $createdate
 * @property integer $running_days
 */
class Sigin extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user_sigin}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sigindata', 'createdate','running_days'], 'required'],
            [['sigindata', 'createdate','running_days'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'sigindata' => Yii::t('app','Sign Data'),
            'running_days' => Yii::t('app','Running Days'),
        ];
    }

    public function getKey($all, $key = null, $userId = null)
    {
        $userId = ($userId === null) ? Yii::$app->user->id : $userId ;
        if ($all == true) {
            return Yii::$app->db->createCommand('SELECT * FROM {{%user_sigin}} WHERE user_id='.$userId)->queryOne();
        }
        return Yii::$app->db->createCommand("SELECT $key FROM {{%user_sigin}} WHERE user_id=$userId")->queryScalar();
    }

    public function updateKey($key, $userId, $nums = 1, $add = true)
    {
        switch ($key) {
            case 'sigindata':
            case 'limit_posting':
            case 'limit_attention':
            case 'limit_comment':
                break;
            default:
                return false;
                break;
        }
        if ($add) {
            return Yii::$app->db->createCommand("UPDATE {{%user_sigin}} SET {$key}={$key}+{$nums} WHERE user_id=".$userId)->execute();
        } else {
            return Yii::$app->db->createCommand("UPDATE {{%user_sigin}} SET {$key}={$nums} WHERE user_id=".$userId)->execute();
        }
    }

    /**
     * tq
     *限制每天发帖，关注，评论..数量的积分累加
     * $type:发帖，关注，评论..
     * $days:限制每天条数，默认3条，即每天的前三条有积分，多发没有积分
     * $userId用户ID
     *
     */
    public function checkDayCount($type,$days=3,$userId=null){

        $userId = ($userId === null) ? Yii::$app->user->id : $userId ;

        $ifToday = strtotime('today') - $this->getKey(false,'posting_at',$userId);

        if($ifToday===0){

            if($this->getKey(false,$type,$userId)<$days){

                $this->updateKey($type,$userId);
                return true;

            }else{

                return false;
            }

        }else{

            Yii::$app->db->createCommand("UPDATE {{%user_sigin}} SET {$type}=1,posting_at=".strtotime('today')." WHERE user_id=".$userId)->execute();
            return true;
        }
    }

    public static function getIsSign($userId=null){

        $userId = ($userId === null) ? Yii::$app->user->id : $userId;
        $query = Yii::$app->db->createCommand("SELECT createdate from {{%user_sigin}} WHERE user_id=".$userId)->queryScalar();
        if($query==strtotime('today')){
            return true;
        }else{
            return false;
        }

    }
}
