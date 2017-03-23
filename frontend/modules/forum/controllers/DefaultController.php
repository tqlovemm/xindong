<?php
namespace frontend\modules\forum\controllers;

use Yii;
use frontend\modules\forum\models\AnecdoteThreadCommentComments;
use frontend\modules\forum\models\AnecdoteThreadComments;
use frontend\modules\forum\models\AnecdoteThreadImages;
use frontend\modules\forum\models\AnecdoteThreadReport;
use frontend\modules\forum\models\AnecdoteThreadThumbs;
use frontend\modules\forum\models\AnecdoteUsers;
use frontend\modules\forum\models\User;
use frontend\modules\forum\models\AnecdoteThreads;
use shiyang\qqlogin\lib\Oauth;
use shiyang\qqlogin\lib\Qc;
use yii\helpers\Html;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $this->layout = '/basic';
        $model = AnecdoteThreads::find()
            ->from(AnecdoteThreads::tableName().' as at')
            ->where(['at.status'=>4])
            ->with('img')
            ->with('comments')
            ->with('thumbs')
            ->with('user')
            ->asArray()
            ->orderBy('at.updated_at desc')
            ->limit(5)
            ->all();
        $id = $this->getJudgeLog();
        return $this->render('index',['model'=>$model,'is_log'=>$id]);
    }

    public function actionAjaxIndex($id){

        $pre_url = Yii::$app->params['threadimg'];
        $model = AnecdoteThreads::find()
            ->from(AnecdoteThreads::tableName().' as at')
            ->where(['at.status'=>4])
            ->AndWhere("at.tid < {$id}")
            ->With('img')
            ->With('comments')
            ->With('thumbs')
            ->With('user')
            ->asArray()
            ->limit(14)
            ->orderBy('at.updated_at desc')
            ->all();
        if($model !== null ){

        $str = '';
        foreach ($model as $item){
            if($item['type']==1){
                $str .= '<div class="box myfirst" data-id="';
                $str .= $item["tid"];
                $str .= '">';
                $str .= '<div class="row">';
                $str .= '<a href="/forum/default/view?tid=';
                $str .= $item["tid"];
                $str .= '&top=bottom">';
                $str .= '<h5 style="padding: 10px 5px;margin: 0;line-height: 20px;">';
                $str .= \yii\helpers\Html::encode(\yii\myhelper\Helper::truncate_utf8_string($item['content'],35));
                $str .= '</h5>';
                $str .= '<div class="img-box clearfix">';
                if(count($item["img"])==1){
                    foreach ($item["img"] as $key=>$img) {
                        $str .= '<div style="padding: 0 0 0 5px;" class="col-xs-6">';
                        $str .= '<img class="img-responsive lazy" src="'.$pre_url.$img["img"].'"></div>';
                    }
                }elseif(count($item["img"])==2) {
                    foreach ($item["img"] as $key => $img) {

                        $str .= '<div class="col-xs-6" style="';
                        if ($key == 1) {
                            $str .= 'float:right;';
                        }
                        $str .= 'height: 130px;overflow: hidden;">';
                        $str .= '<img class="img-responsive lazy" src="'.$pre_url.$img["img"].'"></div>';
                    }
                }elseif(count($item["img"])>=3) {
                    foreach ($item["img"] as $key => $img){

                        $str .= '<div class="col-xs-4" style="';
                        if($key==1){$str .= 'margin:0 0.6%;';}
                        if($key==2){$str .= 'float:right;';}
                        $str .= 'height: 105px;overflow: hidden;">';
                        $str .= '<img class="img-responsive lazy" src="'.$pre_url.$img["img"].'"></div>';
                        if ($key == 2){ break;}
                    }
                }
                $str .= '</div>';
                $str .= '</a>';
                $str .= '</div>';
                $str .= '<div class="row">';
                $str .= '<ul class="list-group list-inline">';
                $str .= '<li class="thumbs_up" onclick="thumbs_total(';
                $str .= $item["tid"];
                $str .=',1,this)"><span class="glyphicon glyphicon-thumbs-up';
                if($item['thumbs']['type']==1){$str .= ' up_down_active';}
                $str .= '"></span> <span class="count">';
                $str .= $item["thumbsup_count"];
                $str .= '</span></li>';
                $str .= '<li class="thumbs_down" onclick="thumbs_total(';
                $str .= $item["tid"];
                $str .= ',2,this)"><span class="glyphicon glyphicon-thumbs-down';
                if($item['thumbs']['type']==2){$str .= ' up_down_active';}
                $str .= '"></span> <span class="count">';
                $str .= $item["thumbsdown_count"];
                $str .= '</span></li>';
                $str .= '<li><a href="/forum/default/view?tid=';
                $str .= $item["tid"];
                $str .= '&top=bottom"><span class="glyphicon glyphicon-comment"></span> <span>';
                $str .= count($item["comments"]);
                $str .= '</span></a></li></ul></div>';
                $str .= '</div>';
            }
        }

            echo json_encode($str);

        }else{
            echo '';
        }
    }

    //前往QQ登陆
    protected function logByQQ(){
        $user_id = $this->getUserId();
        if((empty($_COOKIE['13_qq_access_token'])||empty($_COOKIE['13_qq_openid'])) && empty($user_id)){
            return $this->redirect('/forum/default/qq-login');
        }
    }

    //判断是否登陆
    protected function getJudgeLog(){
        $user_id = $this->getUserId();
        $opendId = empty($_COOKIE['13_qq_access_token'])?(empty($_COOKIE['13_qq_openid'])?null:$_COOKIE['13_qq_openid']):$_COOKIE['13_qq_access_token'];
        if($user_id && $opendId){
            //如果QQ和平台都登陆了，有先平台登陆，删除QQ登陆cookie
            Yii::$app->response->cookies->remove('13_qq_access_token');
            Yii::$app->response->cookies->remove('13_qq_openid');
            $id = $user_id;
        }else{
            $id = empty($user_id)?(empty($opendId)?null:$opendId):$user_id;
        }

        return $id;


    }

    public function actionView($tid){
        $this->layout = '/basic';
        $thread = AnecdoteThreads::find()
            ->where(['pre_anecdote_threads.tid'=>$tid])
            ->With('img')
            ->With('comments')
            ->With('thumbs')
            ->With('user')
            ->asArray()
            ->one();
        $comments = AnecdoteThreadComments::find()
            ->where(['pre_anecdote_thread_comments.tid'=>$tid,'pre_anecdote_thread_comments.status'=>1])
            ->with('user')
            ->with('cos')
            ->With('thumbs');
        return $this->render('view',['thread'=>$thread,'comments'=>$comments]);
    }

    protected function getUserId(){

        $user_id = (string)Yii::$app->user->id;
        if(!$user_id){
            $user_id = isset($_COOKIE['13_qq_openid'])?$_COOKIE['13_qq_openid']:null;
        }

        return $user_id;
    }

    /**
     * @param $tid
     * @param $type
     * @return string|\yii\web\Response
     */
    public function actionThumbs($tid,$type){

        if($this->getJudgeLog() == null){
            echo 4;die;
        }
        $user_id = $this->getUserId();
        $user_thumbs = new AnecdoteThreadThumbs();

        if(($thumbs=AnecdoteThreadThumbs::findOne(['tid'=>$tid,'user_id'=>$user_id,'where'=>1]))==null){

            $user_thumbs->user_id = $user_id;
            $user_thumbs->type = $type;
            $user_thumbs->tid = $tid;
            $user_thumbs->save();

            $thread = AnecdoteThreads::findOne(['tid'=>$tid]);
            if($type==1){
                $thread->thumbsup_count+=1;
            }else{
                $thread->thumbsdown_count+=1;
            }
            $up_count = $thread->thumbsup_count;
            $down_count = $thread->thumbsdown_count;
            $count  = json_encode(array('up'=>$up_count,'down'=>$down_count));
            $thread->update();
            return $count;

        }else{

            if($thumbs->type==$type){

                $thumbs->delete();
                $thread = AnecdoteThreads::findOne(['tid'=>$tid]);
                if($type==1){
                    $thread->thumbsup_count-=1;

                }else{
                    $thread->thumbsdown_count-=1;

                }
                $up_count = $thread->thumbsup_count;
                $down_count = $thread->thumbsdown_count;
                $count  = json_encode(array('up'=>$up_count,'down'=>$down_count,'status'=>10));
                $thread->update();
                return $count;

            }else{

                $thumbs->type=$type;
                $thumbs->update();
                $thread = AnecdoteThreads::findOne(['tid'=>$tid]);
                if($type==1){
                    $thread->thumbsup_count+=1;
                    $thread->thumbsdown_count-=1;
                }else{
                    $thread->thumbsup_count-=1;
                    $thread->thumbsdown_count+=1;
                }

                $up_count = $thread->thumbsup_count;
                $down_count = $thread->thumbsdown_count;
                $count  = json_encode(array('up'=>$up_count,'down'=>$down_count));
                $thread->update();
                return $count;

            }
        }
    }

    public function actionCommentThumbs($cid){

        if($this->getJudgeLog() == null){
            echo 4;die;
        }
        $user_id = $this->getUserId();

        $user_thumbs = new AnecdoteThreadThumbs();
        $comment = AnecdoteThreadComments::findOne($cid);

        if(($thumbs=AnecdoteThreadThumbs::findOne(['tid'=>$cid,'user_id'=>$user_id,'where'=>2]))==null){

            $user_thumbs->tid = $cid;
            $user_thumbs->user_id = $user_id;
            $user_thumbs->type = 1;
            $user_thumbs->where = 2;
            if($user_thumbs->save()){
                $comment->thumbsup_count+=1;
                $count  = json_encode(array('up'=>$comment->thumbsup_count,'status'=>10));
                $comment->update();
                return $count;
            }else{
                echo "<script>alert('系统错误')</script>";
            }

        }
    }

    /**
     * 支持本平台用户和游客发帖
    */
    public function actionBeforePushThread(){

        if($this->getJudgeLog() == null){
            return $this->redirect('choice-login');
        }
        $user_id = $this->getUserId();

        $user = AnecdoteUsers::findOne(['user_id'=>$user_id]);

        if(!$user){

            $userInfo = User::findOne(['id'=>$user_id]);
            $model0 = new AnecdoteUsers();
            $model0->user_id = $user_id;
            $model0->headimgurl = $userInfo['avatar'];
            $model0->username = $userInfo['username'];
            $model0->save();
        }

        $model = AnecdoteThreads::findOne(['user_id'=>$user_id,'status'=>1]);

        if(empty($model)){
            $model = new AnecdoteThreads();
            $model->user_id = $user_id;
            $model->save();
        }
        $img = $model->img;
        return $this->render('push-thread',['img'=>$img,'model'=>$model]);

    }

    /**
     *  举报
     *
     */

    public function actionReport($tid = 0){

        if($this->getJudgeLog() == null){

            return $this->redirect('choice-login');
        }

        $user_id = $this->getUserId();
        if($tid){

            $info = AnecdoteThreads::find()->where(['tid'=>$tid,'status'=>2])->asArray()->one();
            if($info){
                $user = AnecdoteUsers::find()->where(['user_id'=>$info['user_id']])->asArray()->one();
                $exist = AnecdoteThreadReport::find()->where(['by_who'=>$user_id,'tid'=>$tid])->one();
                if($exist){
                    return $this->render('report',['user'=>$user,'thread'=>$info,'exist'=>$exist]);
                }else{
                    return $this->render('report',['user'=>$user,'thread'=>$info]);
                }
            }
        }else{

            $data = Yii::$app->request->post();
            //避免重复提交
            $exist = AnecdoteThreadReport::find()->where(['by_who'=>$user_id,'tid'=>$data['tid']])->one();
            if($exist){
                echo '你已举报过了';
            }else{

                $model0 = new AnecdoteThreadReport();
                $model0->tid = $data['tid'];
                $model0->by_who = $user_id;
                if(empty(htmlspecialchars($data['content']))){
                    echo '举报原因不能为空';die;
                }
                $model0->reason = $data['content'];
                if($model0->save()){
                    echo '举报成功,我们将会核实情况后进行处理，感谢您的监督和支持';
                }else{//'举报失败'
                    /*echo array_values($model0->getFirstErrors())[0];*/
                    echo '举报失败';
                }
            }
        }
    }

    public function actionChoiceLogin(){

        return $this->render('choice-login');

    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionPushThread(){

        if($this->getJudgeLog() == null){
            return $this->redirect('choice-login');
        }
        $user_id = $this->getUserId();

        $user = AnecdoteUsers::findOne(['user_id'=>$user_id]);
        if(empty($user)){
            return $this->redirect('choice-login');
        }
        $model = AnecdoteThreads::findOne(['user_id'=>$user_id,'status'=>1]);

        if(empty($model)){
            $model = new AnecdoteThreads();
            $model->user_id = $user_id;
            $model->save();
        }
        $img = $model->img;
        return $this->render('push-thread',['img'=>$img,'model'=>$model]);
    }


    public function actionPushComments($tid,$level=1,$to_user_id=''){

        if($this->getJudgeLog() == null){
            return $this->redirect('choice-login');
        }
        $user_id = $this->getUserId();

        $user = AnecdoteUsers::findOne(['user_id'=>$user_id]);
        if(empty($user)){
            return $this->redirect('qq-login');
        }

        if($level==1){
            return $this->render('push-comments', [
                'tid' => $tid,'level'=>1,'to_user_id'=>''
            ]);
        }elseif($level==2){
            return $this->render('push-comments', [
                'tid' => $tid,'level'=>$level,'to_user_id'=>$to_user_id
            ]);
        }
    }

    public function actionSaveCosComment(){

        if($this->getJudgeLog() == null){
            return $this->redirect('choice-login');
        }
        $user_id = $this->getUserId();
        $user = AnecdoteUsers::findOne(['user_id'=>$user_id]);

        if(empty($user)){
            return $this->redirect('qq-login');
        }
        $post = Yii::$app->request->post();

        $model = new AnecdoteThreadCommentComments();
        if($model::find()->where(['user_id'=>$user_id])->count()<50){
            $model->user_id = $user_id;
            $model->to_user_id = $post['to_user_id'];
            $model->content = $post['comment'];
            $model->cid = $post['tid'];
            if($model->save()){
                $backid = AnecdoteThreadComments::findOne(['cid'=>$post['tid']]);
                return $this->redirect("view?tid={$backid->tid}&top=bottom");
            }
        }else{
            return "个人评价不超过50条";
        }
    }

    public function actionSaveComment(){

        if($this->getJudgeLog() == null){
            return $this->redirect('choice-login');
        }
        $user_id = $this->getUserId();
        $user = AnecdoteUsers::findOne(['user_id'=>$user_id]);

        if(empty($user)){
            return $this->redirect('qq-login');
        }
        $post = Yii::$app->request->post();

        $model = new AnecdoteThreadComments();
        if($model::find()->where(['user_id'=>$user_id])->count()<50){

            $model->user_id = $user_id;
            $model->tid = $post['tid'];
            $model->comment = $post['comment'];
            if($model->save()){
                return $this->redirect("view?tid=$post[tid]&top=bottom");
            }
        }else{

            return "个人评价不超过50条";

        }
    }
    public function actionSaveInfo($id){

        $model = $this->findModel($id);
        $model->content = Html::encode(Yii::$app->request->post('declaration'));
        $model->status = 2;

        if($model->save()){
            return $this->redirect('index');
        }
    }

    public function actionUploader($id){

        $thread = $this->findModel($id);

        $data = $thread->upload();

        $html = <<<defo
        <img onclick="delete_img($data[id])" src=$data[path] data-id=$data[id] class="preview collecting-files-img">
defo;
        echo $html;

    }

    public function actionQqLogin(){

        $oauth = new Oauth();
        $oauth->qq_login();
    }
    public function actionCallback($url='index'){

        $guest = $this->guest();
        $qc = new Qc($guest['13_qq_access_token'],$guest['13_qq_openid']);
        $user_info = $qc->get_user_info();
        $user = new AnecdoteUsers();
        if(empty($user::findOne(['user_id'=>$guest['13_qq_openid']]))){
            $user->user_id = $guest['13_qq_openid'];
            $user->username = $user_info['nickname'];
            $user->headimgurl = $user_info['figureurl_qq_2'];
            $user->save();
        }

        return $this->redirect($url);
    }

    protected function guest(){

        $user_id = $this->getUserId();
        if(!$user_id){
            $oauth = new Oauth();

            if(isset($_COOKIE['13_qq_access_token'])){
                $access_token = $_COOKIE['13_qq_access_token'];
            }else{
                $access_token = $oauth->qq_callback();
                setcookie('13_qq_access_token', $access_token, time()+3600*24*7);
            }
            if(isset($_COOKIE['13_qq_openid'])){
                $openid = $_COOKIE['13_qq_openid'];
            }else{
                $openid = $oauth->get_openid();
                setcookie('13_qq_openid',$openid, time()+3600*24*7);
            }
            return array('13_qq_access_token'=>$access_token, '13_qq_openid'=>$openid);
        }
        return array('13_qq_access_token'=>$user_id, '13_qq_openid'=>$user_id);


    }

    public function actionDeleteImg($id){


        $imgModel = AnecdoteThreadImages::findOne($id);
        if($imgModel->delete()){

            echo 'ok';
        }


    }

    protected function findModel($id)
    {
        if (($model = AnecdoteThreads::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
