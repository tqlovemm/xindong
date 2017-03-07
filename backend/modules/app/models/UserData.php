<?php

namespace backend\modules\app\models;

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
 * @property integer $jiecao_coin
 * @property integer $frozen_jiecao_coin
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
            [['post_count', 'feed_count', 'following_count', 'follower_count', 'unread_notice_count', 'unread_message_count', 'thread_count', 'empirical_value', 'jiecao_coin', 'frozen_jiecao_coin'], 'integer']
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
            'jiecao_coin' => 'Jiecao Coin',
            'frozen_jiecao_coin' => 'Frozen Jiecao Coin',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
