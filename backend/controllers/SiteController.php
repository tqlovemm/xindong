<?php
namespace backend\controllers;

use backend\components\MyBehavior;
use frontend\models\UserAvatarCheck;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use common\components\BaseController;
use common\models\LoginForm;
use common\models\User;
use frontend\models\Counter;
use yii\myhelper\SystemMsg;

/**
 * Site controller
 */

class SiteController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error','login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'phpinfo', 'cache',
                            'pcheck','pass','npass','feedback',
                            'feeddelete','feedview','claims',
                            'claimsview','claimsdelete','visit','cvisit','pclaims',
                            'pclaims-delete','send-mailer','file-check','file-check-op'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                 /*       'matchCallback' => function ($rule, $action) {
                            $ip = Yii::$app->getRequest()->getUserIP();
                            if(MyBehavior::enter($ip)){
                                return true;
                            }
                        }*/
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        $userCount = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%user}}")->queryScalar();
        $postCount = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%forum_post}}")->queryScalar();
        $forumCount = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%forum_thread}}")->queryScalar();
        return $this->render('index',[
            'userCount' => $userCount,
            'postCount' => $postCount,
            'forumCount' => $forumCount,
        ]);
    }
    public function actionVisit(){

        $model = new Counter();

        $arr_hour = array();
        $arr_count = array();
        foreach($model->Group() as $val){

            array_push($arr_hour,$val['hour']);
            array_push($arr_count,$val['count']);
        }


        return $this->render('visit',[
            'arr_hour'=>$arr_hour,
            'arr_count'=>$arr_count,
            'today'=>$model->Previously(0),
            'yesterday'=>$model->Previously(1),
            'beforeYesterday'=>$model->Previously(2),
        ]);

    }
    public function actionCvisit(){

        $model = new Counter();
        if($model->Clear(3)){

            return $this->refresh();

        }else{

            return '暂无历史数据！！';

        }

    }


    public function actionPhpinfo()
    {
        ob_start();
        phpinfo();
        $pinfo = ob_get_contents();
        ob_end_clean();
        $phpinfo = preg_replace('%^.*<body>(.*)</body>.*$%ms', '$1', $pinfo);
        $phpinfo = str_replace('<table ', '<div class="table-responsive"><table class="table table-condensed table-bordered table-striped table-hover config-php-info-table"', $phpinfo);
        $phpinfo = str_replace('</table>', '</table></div>', $phpinfo);
        return $this->render('phpinfo', [
            'phpinfo' => $phpinfo
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'site';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }


    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCache($action = null)
    {
        switch ($action) {
            case 'clearall':
                Yii::$app->cache->flush();
                break;
            
            default:
                
                break;
        }
        return $this->render('cache');
    }
    
    public function actionPcheck()
    {

        $query = new Query();
        $query->select('id,username,avatar,avatartemp,updated_at')
              ->from('{{%user}}')
              ->where(['avatarid'=>0])
              ->orderBy('created_at DESC');
        $forumResult = Yii::$app->tools->Pagination($query);
        return $this->render('pcheck', [
            'forums' => $forumResult['result'],
            'pages' => $forumResult['pages'],
        ]);


    }
    public function actionNpass(){

        $id=$_GET['id'];
        $query = new Query();
        $query->createCommand()->update('{{%user}}',['avatarid'=>1],'id='.$id)->execute();

        echo"<script>alert('审核不通过');history.go(-1);</script>";
    }
    public function actionPass(){

        $id=$_GET['id'];
        $query = new Query();
        $query = $query->select('avatartemp')
            ->from('{{%user}}')
            ->where('id='.$id);
        $pages = Yii::$app->tools->Pagination($query);

        $query->createCommand()->update('{{%user}}',['avatarid'=>2],'id='.$id)->execute();
        $query->createCommand()->update('{{%user}}',['avatar'=>$pages['result'][0]['avatartemp']],'id='.$id)->execute();
        echo"<script>alert('审核通过');history.go(-1);</script>";
    }
    public function actionFeedback(){
        $query = new Query();
        $query = $query->select('*')
            ->from('{{%user_feedback}}');
        $pages = Yii::$app->tools->Pagination($query);

        return $this->render('feedback',[

            'pages'=>$pages['pages'],
            'feeds'=>$pages['result'],
        ]);
    }
    public function actionFeedview($id){
        $query = new Query();
        $query = $query->select('*')
            ->from('{{%user_feedback}}')
            ->where(['id'=>$id]);

        $pages = Yii::$app->tools->Pagination($query);

        return $this->render('feedview',['feedones'=>$pages['result']]);
    }
    public function actionFeeddelete($id){

        $query = new Query();

        $query->createCommand()->delete('{{%user_feedback}}',['id'=>$id])->execute();


        return $this->refresh();

    }
    public function actionClaims(){


        $query = new Query();
        $query = $query->select('*')
            ->from('{{%user_claims}}');
        $pages = Yii::$app->tools->Pagination($query);

        return $this->render('claims',[

            'pages'=>$pages['pages'],
            'claims'=>$pages['result'],
        ]);



    }
    public function actionFileCheck(){

        $avatar_check = UserAvatarCheck::find()->where(['status'=>5])->asArray()->all();
        return $this->render('file-check',['avatar_check'=>$avatar_check]);

    }

    public function actionFileCheckOp($status,$id,$reason){

        $model = UserAvatarCheck::findOne(['user_id'=>$id]);
        $model->status = $status;
        $model->reason = $reason;

        if($model->update()){

            $query = \backend\modules\setting\models\SystemMsg::findOne(['user_id'=>$id,'status'=>4]);

            if(!empty($query)){

                $query->delete();
            }

            $user_id = $id;
            $title = "档案照审核";
            $content = ($status == 10)?"恭喜！您的档案照审核通过": "对不起！您的档案照审核不通过，{$reason}，请重新上传";
            $file=$model->file;
            $status=4;
            new SystemMsg($user_id,$title,$content,$file,$status);


            return $this->redirect('file-check');

        }
        return false;


    }


    public function actionClaimsview($id){
        $query = new Query();
        $query = $query->select('*')
            ->from('{{%user_claims}}')
            ->where(['id'=>$id]);

        $pages = Yii::$app->tools->Pagination($query);

        return $this->render('claimsview',['claimsones'=>$pages['result']]);
    }
    public function actionClaimsdelete($id){

        $query = new Query();

        $query->createCommand()->delete('{{%user_claims}}',['id'=>$id])->execute();

        return $this->refresh();
    }
    public function actionPclaims(){


        $result = Yii::$app->db->createCommand('select tc.*,u.username,u.email from {{%thread_claims}} as tc LEFT JOIN {{%user}} as u ON u.id=tc.user_id')->queryAll();
        return $this->render('pclaims',[
            'result'=>$result,
        ]);

    }
    public function actionPclaimsDelete($id){

        Yii::$app->db->createCommand('delete from {{%thread_claims}} where id='.$id)->execute();
        return $this->redirect('pclaims');

    }
    public function actionSendMailer(){

        /* 对于您的投诉反馈，网管哥哥已经着手核实，会尽快处理，给你带来不便请谅解！心动三十一天祝您生活愉快！！*/

        $email = isset($_POST['email'])?$_POST['email']:$_GET['email'];
        $username = isset($_POST['username'])?$_POST['username']:$_GET['username'];

        $obj = isset($_POST['object'])?$_POST['object']:'';
        $content = isset($_POST['content'])?$_POST['content']:'';
        $moObj = '投诉反馈';
        $moContent = '关于您投诉的问题，网管哥哥已经着手核实，近期即会解决相应问题，给您带来不便请谅解！心动三十一天祝您生活愉快！！';
        if($obj&&$content){
            Yii::$app->mailer->compose()
                ->setTo($email)
                ->setSubject($obj)
                ->setTextBody('Plain text content')
                ->setHtmlBody($content)
                ->send();
            Yii::$app->session->setFlash('success','发送成功！！');
            return $this->redirect('pclaims');
        }

        return $this->render('send-mailer',[
            'username'=>$username,
            'email'=>$email,
            'moObj'=>$moObj,
            'moContent'=>$moContent,
        ]);

    }

}
