<?php
//ddd
namespace frontend\controllers;
use Yii;
use yii\base\Controller;
use common\models\User;
use yii\myhelper\Response;
use app\modules\forum\models\Thread;
use app\modules\forum\models\Post;
use yii\myhelper\Easemob;
Yii::setAlias('@avatar','http://182.254.217.147:8888/uploads/user/avatar');
class AppController extends Controller
{
    public $enableCsrfValidation = false;

    /**
     * 202注册成功或者登陆成功
     * 400邮箱已存在
     * 401用户名已存在
     * 402用户名不存在
     * 403密码错误
     * 404参数错误
     * 405action类型不匹配
     * 406手机号码已存在
     */
    public function actionIndex()
    {
        $user = new User();
        if (isset($_GET['action'])) {
            $action = $_GET['action'];
        } else {
            $action = 'registration';
        }
        switch ($action) {
            //注册会员
            case"registration";

                if (!isset($_GET['u'])||!isset($_GET['p'])||!isset($_GET['e'])) {

                    $res = "参数错误";
                    exit(Response::show(404,$res));

                }else{

                    $username = trim($_GET['u']);
                    $password = trim($_GET['p']);
                    $none = md5(md5($password).'13loveme');
                    $email = trim($_GET['e']);
                    $cellphone = isset($_GET['c'])?trim($_GET['c']):'';
                    $sex = isset($_GET['s'])?$_GET['s']:0;
                    $cid = isset($_GET['cid'])?$_GET['cid']:'0';

                if ($this->findModel($username)) {

                    $res = "用户名已存在";
                    exit(Response::show(401,$res));

                }elseif($this->onlyAttribute($email)){

                    $res = "邮箱已存在";
                    exit(Response::show(400,$res));

                } elseif($this->onlyAttribute($cellphone)){

                    $res = "手机号码已经存在";
                    exit(Response::show(406,$res));

                } else {

                    $user->username = $username;
                    $user->setPassword($password);
                    $user->status = 10;
                    $user->cellphone = $cellphone;
                    $user->email = $email;
                    $user->none = $none;
                    $user->sex = $sex;
                    $user->cid = $cid;

                    $user->generateAuthKey();
                    $avatar = 'http://13loveme.com/uploads/user/avatar/default/' . rand(1, 40) . '.jpg';
                    $user->avatar = $avatar;
                    $array = ['username'=>$user->username,'password'=>$none];
                    if($user->save()){

                        $this->setMes()->addUser($array);
                        Yii::$app->db->createCommand()->insert('{{%user_profile}}', [
                            'user_id' => $user->id
                        ])->execute();

                        Yii::$app->db->createCommand()->insert('{{%user_sigin}}', [
                            'user_id' => $user->id,
                        ])->execute();
                        Yii::$app->db->createCommand()->insert('{{%home_album}}', [
                            'created_by' => $user->id,
                            'name' => '我的靓照',
                        ])->execute();
                        Yii::$app->db->createCommand()->insert('{{%user_data}}', [
                            'user_id' => $user->id,
                        ])->execute();

                    }


                    $results = array(
                        'groupid'=>1,
                        'username'=>$username,
                        'status'=>10,
                        'cellphone'=>$cellphone,
                        'email'=>$email,
                        'sex'=>$sex,
                        'avatar'=>$avatar,

                    );
                    $res = "注册成功";
                    exit(Response::show(202,$res,$results));

                    }
                }
                break;

            //会员登录
            case"login";

                if (!isset($_GET['u'])||!isset($_GET['p'])) {

                    $res = "参数错误";
                    exit(Response::show(404,$res));

                }else{


                $username = trim($_GET['u']);
                $password = trim($_GET['p']);
                $cid = isset($_GET['cid'])?$_GET['cid']:'0';
                $result = $this->findModel($username);

                if (empty($result)) {

                    $res = "用户名不存在";
                    exit(Response::show(402,$res));

                } else {

                    $hash = $result['password_hash'];
                    $pass = Yii::$app->security->validatePassword($password, $hash);

                    $query = User::find()->select('status')->where('username=:username',[':username'=>$username])->asArray()->one();

                    if ($pass&&$query['status']==10) {

                        $res = "登录成功";
                        Yii::$app->db->createCommand("update {{%user}} set cid='$cid' where username='$username'")->execute();
                        exit(Response::show(202,$res,$result));

                    } elseif($pass&&$query['status']!==10) {

                        $res = "账户不存在";
                        exit(Response::show(402,$res));

                    }elseif(!$pass&&$query['status']==10){

                        $res = "密码错误";
                        exit(Response::show(403,$res));

                    }else{

                        $res = "账户不存在或密码错误";
                        exit(Response::show(402,$res));

                    }
                }
            }
            break;
            case"setPassword";

                if (!isset($_GET['u'])||!isset($_GET['p'])) {

                    $res = "参数错误";
                    exit(Response::show(404,$res));

                }else{

                $username = trim($_GET['u']);
                $password = trim($_GET['p']);
                $newPassword = trim($_GET['n']);
                $result = $this->findModel($username);

                if (empty($result)) {

                    $res = "用户名不存在";
                    exit(Response::show(402,$res));

                } else {
                    $user->setPassword($newPassword);
                    $hash = $result['password_hash'];
                    $pass = Yii::$app->security->validatePassword($password, $hash);

                    if ($pass) {

                        $res = "登录成功";
                        exit(Response::show(202,$res,$result));

                    } else {

                        $res = "密码错误";
                        exit(Response::show(403,$res));
                    }
                }
            }
            break;

            default:
                $res = "action类型不匹配";
                exit(Response::show(405,$res));
                break;
        }
    }
    protected function findModel($username){

        $model = User::find()
            ->select(['id','groupid','username','email','cellphone','sex','status','avatar','password_hash'])
            ->where('username=:username', [':username' => $username])
            ->asArray()->one();
            return $model;
    }

    protected function onlyAttribute($attribute){

        if (strpos($attribute, '@')) {
            $param = 'email';
        } elseif(is_numeric($attribute)) {
            $param = 'cellphone';
        }else{
            $param = 'username';
        }
        if(!empty(User::find()->where("$param=:$param",[$param=>$attribute])->asArray()->one())){

            return true;

        }else{

            return false;
        }

    }


    public function actionThread(){
        /**
         * 13loveme.com/index.php/app/thread?action=t_lists
         * action：
         * t_lists查看全部帖子
         * ********返回内容**********
         * username:用户名
         * avatar:用户头像
         * content:帖子内容
         * birthdate:用户生日
         * note:点赞数
         * created_at:发帖时间
         * post_count:回帖数
         * read_count:阅读数
         *
         * 13loveme.com/index.php/app/thread?action=p_lists&id=1154
         * p_lists查看某条帖子的全部回帖信息 id为帖子id
         * ********返回内容**********
         * id:用户ID
         * username:用户名
         * avatar:用户头像
         * content:回帖内容
         * created_at:回帖时间
         *
         * 13loveme.com/index.php/app/thread?action=post
         * post用户发帖
         * ***********需要内容***********
         * post过来的images图片数组（images必须为数组）
         * post过来的text帖子内容
         * post过来的user_id用户id
         *
         * 13loveme.com/index.php/app/thread?action=reply
         * reply用户回帖
         * post方式传递三个参数
         * text回帖内容
         * user_id用户id
         * thread_id帖子id
         *
         * 13loveme.com/index.php/app/thread?action=likes
         * 帖子点赞
         * post 两个个参数
         * user_id 用户id
         * thread_id帖子id
         *
         * 13loveme.com/index.php/app/thread?action=read
         * 帖子阅读数
         * get一个参数all=0或者1,0代表阅读一个帖子，阅读数增加，1代表阅读了所有的帖子
         * 如果为0 需要post一个参数:thread_id帖子id。
         *
        */
        if (isset($_GET['action'])) {$action = $_GET['action'];} else {$action = 'default';}

        switch($action){

            case't_lists';
                $command = Yii::$app->db->createCommand('
                          SELECT u.id as user_id,u.groupid,u.username,u.avatar,u.email,u.cellphone,u.sex,u.created_at,p.birthdate,t.id as thread_id,t.content,t.image_path as image,t.created_at,t.note,t.post_count,t.read_count
                          FROM {{%forum_thread}} as t
                          LEFT JOIN {{%user}} as u ON u.id=t.user_id
                          LEFT JOIN {{%user_profile}} as p ON p.user_id=t.user_id');
                $posts = $command->queryAll();

                $post_list = array();

                foreach($posts as $post){

                    $postUser = array('user_id'=>$post['user_id'],'group_id'=>$post['groupid'],'username'=>$post['username'],'avatar'=>Yii::getAlias('@avatar').'/'.$post['avatar'],'birthdate'=>$post['birthdate'],'cellphone'=>$post['cellphone'],'email'=>$post['email'],'sex'=>$post['sex'],'created_at'=>$post['created_at']);
                    $post['user'] = $postUser;

                    $post['content']= preg_replace('/<[^>]+>/','',$post['content']);
                    $post['image'] = json_decode($post['image']);

                    unset($post['username']);unset($post['avatar']);unset($post['birthdate']);unset($post['cellphone']);unset($post['email']);unset($post['sex']);
                    unset($post['user_id']);unset($post['groupid']);unset($post['created_at']);

                    array_push($post_list,$post);

                }
                $res = '帖子列表';

                exit(Response::show(202,$res,$post_list));
                break;

            case'p_lists';
                if (isset($_GET['id'])) {$id = $_GET['id'];} else {$id = 'default';}
                $command2 = Yii::$app->db->createCommand('
                          SELECT up.birthdate,u.id as user_id,u.groupid,u.username,u.avatar,u.email,u.cellphone,u.sex,u.created_at,fp.id as post_id,fp.content,fp.created_at as time
                          from {{%forum_post}} as fp
                          LEFT JOIN {{%user}} as u ON u.id=fp.user_id
                          LEFT JOIN {{%user_profile}} as up ON up.user_id=fp.user_id
                          WHERE fp.thread_id='.$id);
                $posts2 = $command2->queryAll();

                $post_list = array();

                foreach($posts2 as $post){

                    $postUser = array('user_id'=>$post['user_id'],'group_id'=>$post['groupid'],'birthdate'=>$post['birthdate'],
                        'username'=>$post['username'],'avatar'=>Yii::getAlias('@avatar').'/'.$post['avatar'],'cellphone'=>$post['cellphone'],'email'=>$post['email'],'sex'=>$post['sex'],'created_at'=>$post['created_at']);
                    $post['user'] = $postUser;

                    $post['content']= preg_replace('/<[^>]+>/','',$post['content']);

                    unset($post['username']);unset($post['avatar']);unset($post['cellphone']);unset($post['email']);unset($post['sex']);
                    unset($post['user_id']);unset($post['groupid']);unset($post['created_at']);unset($post['birthdate']);

                    array_push($post_list,$post);

                }


                $res = '回帖列表';
                exit(Response::show(202,$res,$post_list));
                break;


        }

    }

    protected function setMes(){

        $options = array(
            'client_id'  => 'YXA6zamAUIOdEeWcWzkZK3TkBQ',   //你的信息
            'client_secret' => 'YXA6nN7MHrOfmJi8V3viG6s9lG8IYlc',//你的信息
            'org_name' => 'thirtyone' ,//你的信息
            'app_name' => 'chatapp' ,//你的信息
        );
        $e = new Easemob($options);

        return $e;
    }



/*end*/
}