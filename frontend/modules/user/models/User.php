<?php

namespace app\modules\user\models;

use app\modules\forum\models\Thread;
use Yii;
use yii\db\Query;
use app\modules\home\models\Post;
use app\modules\home\models\Feed;

/**
 * This is the model class for table "{{%user}}".
 *
 * @property integer $id
 * @property string $username
 * @property string $password
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $auth_key
 * @property string $nickname
 * @property string $cellphone
 * @property integer $role
 * @property integer $status
 * @property string $invitation
 * @property string $email
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $avatar
 * @property string $none
 */
class User extends \common\models\User
{
    public $oldPassword;
    public $newPassword;
    public $verifyPassword;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            [['nickname','cellphone'],'required'],
/*          [['username'], 'string', 'max' => 32, 'min' => 5],
            [['username'], 'match', 'pattern' => '/^(?!_)(?!.*?_$)(?!\d{5,32}$)[a-z\d_]{5,32}$/i'],*/

            ['nickname','string','max'=>255],
            ['cellphone', 'string', 'max' => 11, 'min' => 11],
            ['cellphone', 'match', 'pattern' => '/1[345678]{1}\d{9}$/'],

            [['role', 'status', 'created_at', 'updated_at'], 'integer'],
            [['password_hash', 'password_reset_token', 'auth_key','none'], 'string'],
            [['email'], 'email'],
            [['avatar'], 'string', 'max' => 255],
            [['email'], 'unique'],
            [['username'], 'unique'],
            // oldPassword is validated by validateOldPassword()
            [['oldPassword'], 'validateOldPassword'],
            [['verifyPassword'], 'compare', 'compareAttribute' => 'newPassword'],
            [['oldPassword', 'verifyPassword', 'newPassword'], 'required']
        ];
    }

    public function validateOldPassword()
    {
        $user = parent::findOne($this->id);

        if (!$user || !$user->validatePassword($this->oldPassword)) {
            Yii::$app->getSession()->setFlash('error', 'Incorrect password.');
            $this->addError('password', 'Incorrect password.');
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'username' => '用户名',
            'nickname' => '昵称',
            'password' =>'密码',
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'oldPassword' => '旧密码',
            'newPassword' => '新密码',
            'verifyPassword' => '确认密码',
            'auth_key' => Yii::t('app', 'Auth Key'),
            'role' => Yii::t('app', 'Role'),
            'status' => Yii::t('app', 'Status'),
            'email' => '邮箱',
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'avatar' => Yii::t('app', '用户头像'),
            'cellphone' => '手机号码',
            'sex' => '性别',

        ];
    }

    public function scenarios()
    {
        return [
            'default' => ['nickname','cellphone'],
            'security' => ['oldPassword', 'newPassword', 'verifyPassword'],
        ];
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * app\modules\home\models\Post
     * @return array
     */
    public function getPosts()
    {
        //return $this->hasMany(Post::className(), ['user_id' => 'id'])->orderBy('id DESC');
        $query = Post::find()->where(['user_id' => $this->id])->orderBy('id desc');
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 14;
        $posts = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return ['posts' => $posts, 'pages' => $pages];
    }
    
    /**
     * app\modules\home\models\Feed
     * @return array
     */
    public function getFeeds()
    {
        $query = Feed::find()->where(['user_id' => $this->id])->orderBy('id desc');
        $countQuery = clone $query;
        $pages = new \yii\data\Pagination(['totalCount' => $countQuery->count()]);
        $pages->defaultPageSize = 14;
        $feeds = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        return ['feeds' => $feeds, 'pages' => $pages];
    }

    public static function getInfo($id)
    {
        $query = new Query;
        $user = $query->select('username, avatar,nickname')
                ->from('{{%user}}')
                ->where('id=:id', [':id' => $id])
                ->one();
        return $user;
    }

    public function getProfile()
    {
        return $this->hasOne(Profile::className(), ['user_id' => 'id']);
    }
    public function getThread()
    {
        return $this->hasMany(Thread::className(), ['user_id' => 'id']);
    }

    public function getUserData()
    {
        return $this->hasOne(UserData::className(), ['user_id' => 'id']);
    }

    /**
     * 获取论坛的评论
     */
    public function getComments()
    {
        $query = new Query;
        $query = $query->select('t.id, t.title, t.content, p.user_id, p.content as comment, p.created_at, u.username, u.avatar')
            ->from('{{%forum_post}} as p')
            ->join('LEFT JOIN','{{%forum_thread}} as t', 'p.thread_id=t.id')
            ->join('LEFT JOIN','{{%user}} as u', 'u.id=p.user_id')
            ->where('t.user_id=:user_id and p.user_id !=:user_id', [':user_id' => $this->id])
            ->orderBy('p.created_at DESC');

        return Yii::$app->tools->Pagination($query);
    }

    /**
     * 获取所有关注的用户信息
     * @param string $type 类型，'following':关注用户, 'follower':粉丝
     */
    public function getFollow($type)
    {
        $query = new Query;
        switch ($type) {
            case 'following':
                $query->select('u.id, u.username, u.avatar')
                    ->from('{{%user}} as u')
                    ->join('LEFT JOIN','{{%user_follow}} as f', 'f.people_id = u.id')
                    ->where('f.user_id = :user_id', [':user_id' => $this->id])
                    ->orderBy('f.id DESC');
                break;
            case 'follower':
                $query->select('u.id, u.username, u.avatar')
                    ->from('{{%user}} as u')
                    ->join('LEFT JOIN','{{%user_follow}} as f', 'f.user_id = u.id')
                    ->where('f.people_id = :user_id', [':user_id' => $this->id])
                    ->orderBy('f.id DESC');
                break;
            default:
                return false;
                break;
        }
        return Yii::$app->tools->Pagination($query);
    }

    /**
     * 当前登录的用户是否已经关注了 $id 用户
     * @param integer $type 
     * @return boolean 是否用户已经关注
     */
    public static function getIsFollow($id)
    {
        $done = Yii::$app->db
            ->createCommand("SELECT 1 FROM {{%user_follow}} WHERE user_id=:user_id AND people_id=:id LIMIT 1")
            ->bindValues([':user_id' => Yii::$app->user->id, ':id' => intval($id)])->queryScalar();
        return ($done) ? true : false ;
    }

}
