<?php

namespace frontend\modules\weixin\controllers;
use yii\data\Pagination;
use Yii;
use yii\base\Object;
use yii\myhelper\AccessToken;
use yii\myhelper\Jssdk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use frontend\models\WeichatNoteUserinfo;
use frontend\models\DinyueWeichatUserinfo;
use frontend\modules\weixin\models\VoteSignImg;
use frontend\modules\weixin\models\VoteSignInfo;

class WeichatVoteController extends Controller
{
    const NOTE_NUMBER = 10;
    public $enableCsrfValidation = false;
    private $openid;
    private $headimgurl;
    private $nickname;
    private $options;
    private $subscribe;

    public function init()
    {
        $this->options = array(
            'appid'=>Yii::$app->params['appid'],
            'appsecret'=>Yii::$app->params['appsecret'],
        );
        $cookie = \Yii::$app->request->cookies;
        $this->openid = $cookie->getValue('vote_01_openid');
        $this->headimgurl = $cookie->getValue('vote_01_headimgurl');
        $this->nickname = $cookie->getValue('vote_01_nickname');
        $this->subscribe = $cookie->getValue('vote_01_subscribe');

        if(empty($this->openid)){

            return $this->redirect('weichat-vote/vote-check');
        }

        parent::init();
    }

    public function actionIndex(){

        var_dump($this->headimgurl);
        var_dump($this->nickname);
        var_dump($this->subscribe);
        return var_dump($this->openid);
    }
    protected function getCode($callback){
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$this->options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
        return $this->redirect($url);

    }
    public function actionVoteCheck(){

        $callback = "http://13loveme.com/weixin/weichat-vote/wei-user";
        $this->getCode($callback);
    }

    public function actionWeiUser(){

        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');

        if(!empty($data['code'])){

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$this->options['appid']}&secret={$this->options['appsecret']}&code={$data['code']}&grant_type=authorization_code";

            $access = file_get_contents($url);
            $result = json_decode($access);
            $token = (new AccessToken())->getAccessToken();
            $openid = $result->openid;

            $url3 = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$token&openid=$openid";

            $userInfo = json_decode(file_get_contents($url3),true);

            if(isset($userInfo['errcode'])&&$userInfo['errcode']==40001){
                Yii::$app->cache->delete('access_token_js');
                return $this->redirect('weichat-vote/vote-check');
            }

            $this->addCookie('vote_01_openid',$userInfo['openid']);
            $this->addCookie('vote_01_headimgurl',$userInfo['headimgurl']);
            $this->addCookie('vote_01_nickname',$userInfo['nickname']);
            $this->addCookie('vote_01_subscribe',$userInfo['subscribe']);

            $voteUrl = '/weixin/weichat-vote/vote-man';//投票地址

            return $this->redirect($voteUrl);
        }

    }

    public function actionVoteMan($entry_number=''){

        $this->layout = '@app/themes/basic/layouts/vote_02';

        if(!empty($entry_number)){

            $data = VoteSignInfo::find()->joinWith('voteSignImgs')->where(['pre_vote_sign_info.id'=>$entry_number,'sex'=>0,'status'=>[1,2]]);

        }else{

            $data = VoteSignInfo::find()->joinWith('voteSignImgs')->where(['sex'=>0,'status'=>[1,2]]);
        }

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '70']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

       return $this->render('vote-man',[
           'model' => $model,
           'pages' => $pages,
       ]);

    }

    public function actionVoteWoman($entry_number=''){

        $this->layout = '@app/themes/basic/layouts/vote_02';

        if(!empty($entry_number)){

            $data = VoteSignInfo::find()->joinWith('voteSignImgs')->where(['pre_vote_sign_info.id'=>$entry_number,'sex'=>1,'status'=>[1,2]])->asArray();

        }else{

            $data = VoteSignInfo::find()->joinWith('voteSignImgs')->where(['sex'=>1,'status'=>[1,2]])->asArray();

        }

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '70']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('vote-woman',[
            'model' => $model,
            'pages' => $pages,
        ]);

    }

    public function actionVoteTop(){

        $this->layout = '@app/themes/basic/layouts/vote_02';

        $model_man = VoteSignInfo::find()->joinWith('img')->where(['sex'=>0,'status'=>2])->orderBy('vote_count desc')->asArray()->limit(20)->all();
        $model_woman = VoteSignInfo::find()->joinWith('img')->where(['sex'=>1,'status'=>2])->orderBy('vote_count desc')->asArray()->limit(30)->all();

        return $this->render('vote-top',['model_man'=>$model_man,'model_woman'=>$model_woman]);

    }

    public function actionSignDetail($id){

        $this->layout = '@app/themes/basic/layouts/vote_02';
        $model = $this->findModel($id);
        $model_de = new VoteSignInfo();
        $model_detail = $model_de::find()->select('vote_count')->where(['sex'=>$model->sex,'status'=>[1,2]])->asArray()->all();

        arsort($model_detail);

        $result = array();
        foreach ($model_detail as $item){
            array_push($result,$item['vote_count']);
        }

        $result = array_values(array_unique($result));

        foreach ($result as $key=>$list){

            if(($list==$model->vote_count)){
                if($key!=0){
                    $to = $result[$key-1]-$model->vote_count;
                }else{
                    $to=0;
                }
                break;
            }
        }

        $jsdk = new Jssdk();
        $signPackage = $jsdk->getSignPackage();

        return $this->render('sign-detail',['model'=>$model,'to'=>$to,'rank'=>$key+1,'signPackage'=>$signPackage,'show'=>Yii::$app->request->get()]);

    }

    public function actionVoteClick($id){

        $query = VoteSignInfo::findOne($id);

        if(1){

            $query->vote_count+=1;
            $query->update();

            $result = $this->toAndRank($query);
            echo $query->vote_count."<script>
            if(confirm('[男神女神评选]您已成功为{$id}号投了一票！当前排名为第{$result['rank']}名，距离前一名还差{$result['to']}票',分享给好友为ta拉票吧)){
                location.href = 'sign-detail?id={$id}&show=1';
            }
            </script>";

        }else{

            echo $query->vote_count."<script>
            if(confirm('您已经投过票了，现在分享给好友为ta拉票吧')){
                location.href = 'sign-detail?id={$id}&show=1';
            }</script>";
        }

    }

    public function actionDeleteImg($id){

        VoteSignImg::findOne($id)->delete();

    }

    public function actionVoteSign(){

        $vote_sign = new VoteSignInfo();

        $query = $vote_sign::findOne(['openid'=>$this->openid]);

        if(empty($query)){

            $vote_sign->openid = $this->openid;
            $vote_sign->headimgurl = $this->headimgurl;
            $vote_sign->nickname = $this->nickname;

            if($vote_sign->save()){

                return $this->render('vote-sign',['model'=>$vote_sign,'img'=>$vote_sign->voteSignImgs]);
            }else{

                var_dump($vote_sign->errors);
            }

        }else{

            if($query->status==1||$query->status==2){

                return $this->redirect('info');

            }
            return $this->render('vote-sign',['model'=>$query,'img'=>$query->voteSignImgs]);
        }

    }

    public function actionInfo(){

        $vote_sign = new VoteSignInfo();
        $query = $vote_sign::findOne(['openid'=>$this->openid]);

        return $this->render('info',['model'=>$query,'img'=>$query->voteSignImgs]);
    }

    public function actionSaveInfo($id){

        $model = $this->findModel($id);
        $model->number = Yii::$app->request->post('number');
        $model->sex = Yii::$app->request->post('sex');
        $model->declaration = Yii::$app->request->post('declaration');
        $model->status = 1;

        if($model->save()){
            return $this->redirect('success?id='.$model->id);
        }
    }

    public function actionSuccess($id){

        return $this->render('vote-success',['id'=>$id]);
    }

    public function actionUploader(){

        $id = Yii::$app->request->post('id');
        $vote_sing_info = $this->findModel($id);

        if($vote_sing_info->status==1||$vote_sing_info->status==2){
            throw new ForbiddenHttpException('无效链接');
        }

        $data = $vote_sing_info->upload();

        $html = <<<defo
        <img src=$data[path] data-id=$data[id] class="preview collecting-files-img">
defo;
        echo $html;

    }

    public function actionPersonalCenter(){

        //$openid = "oxWFGswoCkmnk75DFJ_rxaKVRtJI";
        $openid = $this->openid;

        $query = VoteSignInfo::findOne(['openid'=>$openid,'status'=>[1,2]]);

        $tongJi2 = Yii::$app->db->createCommand("select * from pre_vote_sign_info where id in(select participantid from pre_weichat_note_userinfo where unionid='{$openid}')")->queryAll();

        if(!empty($query)){

            $result = $this->toAndRank($query);
            $data = WeichatNoteUserinfo::find()->select('nickname,sex,headimgurl')->where(['participantid'=>$query->id])->groupBy('openid');

            $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
            $tongJi = $data->offset($pages->offset)->limit($pages->limit)->all();

            return $this->render('personal-center',['query'=>$query,'to'=>$result['to'],'rank'=>$result['rank'],'pages' => $pages,'tj'=>$tongJi,'tj2'=>$tongJi2]);
        }

        return  $this->render('personal-center',['query'=>$query,'to'=>'','rank'=>'','tj'=>array(),'tj2'=>$tongJi2]);
    }

    /**
     * @param $query
     * @return array
     * 排名以及查几票
     */
    protected function toAndRank($query=Object::class){

        $model_de = new VoteSignInfo();
        $model_detail = $model_de::find()->select('vote_count')->where(['sex'=>$query->sex,'status'=>[1,2,3]])->asArray()->all();

        arsort($model_detail);
        $result = array();
        foreach ($model_detail as $item){
            array_push($result,$item['vote_count']);
        }

        $result = array_values(array_unique($result));

        foreach ($result as $key=>$list){

            if(($list==$query->vote_count)){

                if($key!=0){
                    $to = $result[$key-1]-$query->vote_count;
                }else{
                    $to=0;
                }
                break;
            }
        }
        $toAndRank = array('to'=>$to,'rank'=>$key+1);

        return $toAndRank;
    }

    protected function findOpenid($id=0,$before=1){

        $session = Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
        if(empty($session->get('vote_01_openid'))){
            if($before!=1){
                return $this->redirect('/wei-xin/vote-share?id='.$id);
            }
            return $this->redirect('/wei-xin/vote-check');
        }
        $all_session = array('openid'=>$session->get('vote_01_openid'),'headimgurl'=>$session->get('vote_01_headimgurl'),'nickname'=>$session->get('vote_01_nickname'));
        return $all_session;
    }


    protected function addCookie($cookie_name,$cookie_value){

        $cookies = \Yii::$app->response->cookies;
        $cookie = \Yii::$app->request->cookies;
        if(empty($cookie->get($cookie_name))){
            $cookies->add(new \yii\web\Cookie([
                'name' => $cookie_name,
                'value' => $cookie_value,
                'expire'=>time()+3600*24*365,
            ]));
        }
    }

    protected function findModel($id)
    {
        if (($model = VoteSignInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }




}
