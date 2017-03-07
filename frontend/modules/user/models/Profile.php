<?php

namespace app\modules\user\models;

use Yii;

/**
 * This is the model class for table "{{%user_profile}}".
 *
 * @property integer $user_id
 * @property integer $gender
 * @property integer $weight
 * @property string $file_1
 * @property integer $height
 * @property string $birthdate
 * @property string $signature
 * @property string $address
 * @property string $address_1
 * @property string $address_2
 * @property string $address_3
 * @property string $description
 * @property string $mark
 * @property string $make_friend
 * @property string $hobby
 * @property User $user
 */
class Profile extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return '{{%user_profile}}';
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mark','make_friend','hobby','file_1','address', 'description'], 'string'],
            [['user_id','height','weight'], 'integer'],
            [['birthdate'], 'safe'],
            [['signature'], 'string', 'max' => 120],
            [['address_1','address_2','address_3'], 'string', 'max' => 512],
            [['height','weight'], 'integer', 'max' => 250],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'gender' => Yii::t('app', 'Gender'),
            'birthdate' => '生日',
            'file_1'=>'档案照1',
            'signature' => '签名',
            'address' =>'地址',
            'address_1' =>'地址一',
            'address_2' =>'地址二',
            'address_3' =>'地址三',
            'description' => '自我介绍',
            'mark' => '个人标签',
            'make_friend' => '交友要求',
            'hobby' => '兴趣爱好',
            'height' => '身高',
            'weight' => '体重',
        ];
    }
    public function beforeSave($insert)
    {

        if(parent::beforeSave($insert)){

            if($this->isNewRecord){

                $this->user_id = Yii::$app->user->id;

            }

            return true;

        }
        return false;
    }


    public static function getMark($name,$userId = null){

        $userId = ($userId === null) ? Yii::$app->user->id : $userId ;

        return Yii::$app->db->createCommand('select '.$name.' from {{%user_profile}} where user_id='.$userId)->queryOne();
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }



    public function getKey($all, $key = null, $userId = null)
    {
        $userId = ($userId === null) ? Yii::$app->user->id : $userId ;
        if ($all == true) {
            return Yii::$app->db->createCommand('SELECT * FROM {{%user_profile}} WHERE user_id='.$userId)->queryOne();
        }
        return Yii::$app->db->createCommand("SELECT $key FROM {{%user_profile}} WHERE user_id=$userId")->queryScalar();
    }

    /**
     * 更新某个用户的指定Key值的统计数目
     * Key值：
     * post_count：日志总数
     * feed_count：记录总数
     * following_count：关注数
     * follower_count：粉丝数
     * unread_notice_count：评论未读数
     * unread_message_count：未读消息
     * @param string $key Key值
     * @param integer $userId 用户id
     * @param integer $nums 更新的数目，默认为 1
     * @param integer $add  是增加还是设置为
     * @return boolean
     */
    public function updateKey($key, $userId, $nums = 1, $add = true)
    {
        switch ($key) {
            case 'post_count':
            case 'thread_count':
            case 'feed_count':
            case 'following_count':
            case 'follower_count':
            case 'unread_notice_count':
            case 'unread_message_count':
            case 'empirical_value':
                break;
            default:
                return false;
                break;
        }
        if ($add) {
            return Yii::$app->db->createCommand("UPDATE {{%user_data}} SET {$key}={$key}+{$nums} WHERE user_id=".$userId)->execute();
        } else {
            return Yii::$app->db->createCommand("UPDATE {{%user_data}} SET {$key}={$nums} WHERE user_id=".$userId)->execute();
        }
    }



}
