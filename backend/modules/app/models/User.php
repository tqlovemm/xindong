<?php

namespace backend\modules\app\models;

use Yii;

/**
 * This is the model class for table "pre_user".
 *
 * @property integer $id
 * @property string $cid
 * @property integer $groupid
 * @property string $username
 * @property string $nickname
 * @property string $cellphone
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $invitation
 * @property integer $role
 * @property string $sex
 * @property string $identity
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $none
 * @property string $avatar
 *
 * @property AppComplaint[] $appComplaints
 * @property AppComplaint[] $appComplaints0
 * @property AppSelfdating[] $appSelfdatings
 * @property AppWords[] $appWords
 * @property CreditRewardRecord[] $creditRewardRecords
 * @property CreditValue[] $creditValues
 * @property DatingSignup[] $datingSignups
 * @property Forum[] $forums
 * @property ForumBoard[] $forumBoards
 * @property ForumBroadcast[] $forumBroadcasts
 * @property ForumFollow[] $forumFollows
 * @property ForumPost[] $forumPosts
 * @property ForumThread[] $forumThreads
 * @property HomePost[] $homePosts
 * @property JiecaoCoinOperation[] $jiecaoCoinOperations
 * @property JiecaobiNotice[] $jiecaobiNotices
 * @property MakeFriend[] $makeFriends
 * @property RechargeRecord[] $rechargeRecords
 * @property RechargeRecordCopy[] $rechargeRecordCopies
 * @property UserAvatarCheck $userAvatarCheck
 * @property UserData $userData
 * @property UserFollow[] $userFollows
 * @property UserFollow[] $userFollows0
 * @property UserImage[] $userImages
 * @property UserMessage[] $userMessages
 * @property UserMessage[] $userMessages0
 * @property UserPayment[] $userPayments
 * @property UserProfile $userProfile
 * @property UserProfileCopy $userProfileCopy
 * @property UserSigin $userSigin
 * @property WeichatOpenid[] $weichatOpens
 */
class User extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pre_user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'username', 'nickname', 'cellphone', 'password_hash', 'password_reset_token', 'auth_key', 'invitation', 'sex', 'identity', 'email', 'created_at', 'updated_at', 'none', 'avatar'], 'required'],
            [['groupid', 'role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['cid'], 'string', 'max' => 250],
            [['username', 'auth_key'], 'string', 'max' => 32],
            [['nickname', 'none'], 'string', 'max' => 255],
            [['cellphone'], 'string', 'max' => 11],
            [['password_hash'], 'string', 'max' => 60],
            [['password_reset_token'], 'string', 'max' => 43],
            [['invitation'], 'string', 'max' => 50],
            [['sex'], 'string', 'max' => 10],
            [['identity'], 'string', 'max' => 20],
            [['email'], 'string', 'max' => 64],
            [['avatar'], 'string', 'max' => 512]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cid' => 'Cid',
            'groupid' => 'Groupid',
            'username' => 'Username',
            'nickname' => 'Nickname',
            'cellphone' => 'Cellphone',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'auth_key' => 'Auth Key',
            'invitation' => 'Invitation',
            'role' => 'Role',
            'sex' => 'Sex',
            'identity' => 'Identity',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'none' => 'None',
            'avatar' => 'Avatar',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppComplaints()
    {
        return $this->hasMany(AppComplaint::className(), ['plaintiff_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppComplaints0()
    {
        return $this->hasMany(AppComplaint::className(), ['defendant_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppSelfdatings()
    {
        return $this->hasMany(AppSelfdating::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppWords()
    {
        return $this->hasMany(AppWords::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreditRewardRecords()
    {
        return $this->hasMany(CreditRewardRecord::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreditValues()
    {
        return $this->hasMany(CreditValue::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDatingSignups()
    {
        return $this->hasMany(DatingSignup::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForums()
    {
        return $this->hasMany(Forum::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumBoards()
    {
        return $this->hasMany(ForumBoard::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumBroadcasts()
    {
        return $this->hasMany(ForumBroadcast::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumFollows()
    {
        return $this->hasMany(ForumFollow::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumPosts()
    {
        return $this->hasMany(ForumPost::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getForumThreads()
    {
        return $this->hasMany(ForumThread::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHomePosts()
    {
        return $this->hasMany(HomePost::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJiecaoCoinOperations()
    {
        return $this->hasMany(JiecaoCoinOperation::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getJiecaobiNotices()
    {
        return $this->hasMany(JiecaobiNotice::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMakeFriends()
    {
        return $this->hasMany(MakeFriend::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRechargeRecords()
    {
        return $this->hasMany(RechargeRecord::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRechargeRecordCopies()
    {
        return $this->hasMany(RechargeRecordCopy::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserAvatarCheck()
    {
        return $this->hasOne(UserAvatarCheck::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserData()
    {
        return $this->hasOne(UserData::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFollows()
    {
        return $this->hasMany(UserFollow::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserFollows0()
    {
        return $this->hasMany(UserFollow::className(), ['people_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserImages()
    {
        return $this->hasMany(UserImage::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMessages()
    {
        return $this->hasMany(UserMessage::className(), ['sendfrom' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserMessages0()
    {
        return $this->hasMany(UserMessage::className(), ['sendto' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserPayments()
    {
        return $this->hasMany(UserPayment::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfile()
    {
        return $this->hasOne(UserProfile::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserProfileCopy()
    {
        return $this->hasOne(UserProfileCopy::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUserSigin()
    {
        return $this->hasOne(UserSigin::className(), ['user_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWeichatOpens()
    {
        return $this->hasMany(WeichatOpenid::className(), ['user_id' => 'id']);
    }
}
