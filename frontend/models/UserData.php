<?php

namespace frontend\models;

use backend\models\User;
use Yii;

/**
 * This is the model class for table "pre_user_data".
 *
 * @property integer $user_id
 * @property integer $post_count
 * @property integer $feed_count
 * @property integer $following_count
 * @property integer $follower_count
 * @property integer $unread_notice_count
 * @property integer $unread_message_count
 * @property integer $thread_count
 * @property integer $empirical_value
 * @property integer $credit_value
 * @property integer $jiecao_coin
 *
 * @property User $user
 */
class UserData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user_data';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['jiecao_coin'], 'required'],
            [['credit_value', 'jiecao_coin'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => 'User ID',
            'post_count' => 'Post Count',
            'feed_count' => 'Feed Count',
            'following_count' => 'Following Count',
            'follower_count' => 'Follower Count',
            'unread_notice_count' => 'Unread Notice Count',
            'unread_message_count' => 'Unread Message Count',
            'thread_count' => 'Thread Count',
            'empirical_value' => 'Empirical Value',
            'credit_value' => 'Credit Value',
            'jiecao_coin' => 'Jiecao Coin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
    public function getProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'user_id']);
    }

    public static function getJiecaoForNumber($number){

        $profile = self::findModel();
        $user_id = $profile->find()->select('user_id')->where(['number'=>$number])->one();
        $jiecao = UserData::find()->select('jiecao_coin')->where(['user_id'=>$user_id['user_id']])->one();

        return $jiecao['jiecao_coin'];
    }
    public static function getId($number){

        $profile = self::findModel();
        $user_id = $profile->find()->select('user_id')->where(['number'=>$number])->all();

        $user_all = array();
        foreach($user_id as $item){

            $user = User::find()->where(['id'=>$item['user_id']])->asArray()->one();
            array_push($user_all,$user);
        }

        return $user_all;
    }

    public static function getNumberForId($id){

        $profile = self::findModel();
        $user_id = $profile->find()->select('number')->where(['user_id'=>$id])->one();

        return $user_id['number'];

    }

    public static function getIdForNumber($number){

        $profile = self::findModel();
        $user_id = $profile->find()->select('user_id')->where(['number'=>$number])->one();

        return $user_id['user_id'];
    }
    public static function getJiecaoForId($id){

        $jiecao = UserData::find()->select('jiecao_coin')->where(['user_id'=>$id])->one();

        return $jiecao['jiecao_coin'];
    }

    public static function findModel(){

        $model = new UserProfile();

        return $model;

    }
}
