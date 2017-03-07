<?php
namespace frontend\modules\test\controllers;

use Yii;
use yii\base\Object;
use yii\data\Pagination;
use yii\myhelper\Jssdk;
use yii\web\Controller;
use frontend\modules\test\models\VoteUserInfo;
use frontend\modules\test\models\VoteUserGood;
use yii\web\NotFoundHttpException;

class TestController extends Controller
{
    public  $postObj;
    public  $openid;
    public $cache;
    public $enableCsrfValidation = false;

    public function actionWeb(){

        $options = array(
            'appid'=> Yii::$app->params['appid']
        );
        $callback = "http://13loveme.com/test/test/callback";

        $callback = urlencode($callback);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        return $this->redirect($url);
    }
    public function actionCallback(){

        $this->layout = '@app/themes/basic/layouts/vote_header';
        $option = ['appid'=>Yii::$app->params['appid'],'appsecret'=>Yii::$app->params['appsecret']];

        $data['code'] =  Yii::$app->request->get("code");
        if(!empty($data['code'])){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$option['appid']}&secret={$option['appsecret']}&code={$data['code']}&grant_type=authorization_code";

            $access = file_get_contents($url);
            $result = json_decode($access);

            $this->openid = $result->openid;

            if($this->openid){

                $session = Yii::$app->session;
                if(!$session->isActive){
                    $session->open();
                }
                $session->set('openId',$this->openid);

                $model = new VoteUserInfo();

                $model->openId = $this->openid;
                $info = $model::findOne(['openId'=>$this->openid]);
                if(empty($info)){
                    $model->openId = $this->openid;
                    if(!$model->save()){
                        return var_dump("error:500，请联系我们的客服！");
                    }
                    $session->set('Id',Yii::$app->db->getLastInsertID());
                }else{
                    $session->set('Id',$info['id']);
                }
            }
            return $this->redirect("women");
        }

    }

    public function actionClearOpenid(){


        Yii::$app->cache->delete('access_token_js');
    }
    public function actionMan(){

        $this->layout = '@app/themes/basic/layouts/vote_header';

        $data = VoteUserInfo::find()
            ->where(['sex'=>0,'status'=>[1,2]]);
        $count = clone $data;
        $pages = new Pagination(['totalCount' =>$count->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        $userInfo = $this->getSubscribe();
        if(!isset($userInfo['subscribe'])){
            $userInfo['subscribe'] = 0;
        }
        return $this->render('vote-man',['model'=>$model,'pages'=>$pages,'subscribe'=>$userInfo['subscribe']]);
    }

    public function actionWomen(){

        $this->layout = '@app/themes/basic/layouts/vote_header';

        $data = VoteUserInfo::find()->where(['sex'=>1,'status'=>[1,2]]);
        $count = clone $data;
        $pages = new Pagination(['totalCount' =>$count->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        $userInfo = $this->getSubscribe();
        if(!isset($userInfo['subscribe'])){
            $userInfo['subscribe'] = 0;
        }
        return $this->render("vote-woman",['model'=>$model,"pages"=>$pages,'subscribe'=>$userInfo['subscribe']]);//
    }

    //判断是否关注了公众号
    protected function getSubscribe(){
        $openid = Yii::$app->session->get('openId');
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->getAccessToken()}&openid={$openid}";
        $userInfo = json_decode(file_get_contents($url),true);
        return $userInfo;
    }

    public function actionFindOne($entry_number){
        $this->layout = '@app/themes/basic/layouts/vote_header';
        $data = VoteUserInfo::find()->where(['id'=>$entry_number,'status'=>[1,2]])->one();
        $userInfo = $this->getSubscribe();
        if(!isset($userInfo['subscribe'])){
            $userInfo['subscribe'] = 0;
        }
        return $this->render("find-one",['model'=>$data,'subscribe'=>$userInfo['subscribe']]);
    }

    public function actionTop(){

        $this->layout = '@app/themes/basic/layouts/vote_header';
        $top_women = VoteUserInfo::find()
            ->joinWith('img')
            ->joinWith('goods')
            ->where(['sex'=>1,"pre_weichat_vote.status"=>[1,2]])
            ->orderBy('num desc')
            ->asArray()
            ->limit(20)
            ->all();
        $top_man = VoteUserInfo::find()
            ->joinWith('img')
            ->joinWith('goods')
            ->where(['sex'=>0,"pre_weichat_vote.status"=>[1,2]])
            ->orderBy('num desc')
            ->asArray()
            ->limit(20)
            ->all();
        $userInfo = $this->getSubscribe();
        if(!isset($userInfo['subscribe'])){
            $userInfo['subscribe'] = 0;
        }
        return $this->render("vote-top",['women'=>$top_women,'man'=>$top_man,'subscribe'=>$userInfo['subscribe']]);
    }

    public function actionJoin($Id){


        $modelClass = new VoteUserInfo();
        if($Id){
            $model = $modelClass::findOne(['id'=>$Id]);
            if($model->status == 1){
                return $this->redirect("join-info?Id=$Id");
            }
            if(!isset($_GET['status'])){
                $status = "";
            }else{
                $status = "您需填写信息并提交后才能查看个人中心";
            }
            return $this->render("vote-join",['model'=>$model,'imgs'=>$model->imgs,"status"=>$status]);
        }

    }

    public function actionDetail($openId = ""){

        $modelClass = new VoteUserInfo();

        if(!$model = $modelClass::findOne(['openId'=>$openId])){
            var_dump($model->errors);
        }else{

            if($model->status < 1 ){
                $data2  = Yii::$app->request->post();
                $sex = $data2['sex'];
                $enounce = $data2['declaration'];
                $plateId = $data2['number'];
                $status = 1;//信息填写完整为1
                $time = time();
                $res = Yii::$app->db
                    ->createCommand("update pre_weichat_vote set plateId='{$plateId}',sex = {$sex},enounce='{$enounce}',status={$status},updated_at={$time} where openId='{$openId}'")
                    ->execute();
                if($res){
                    return $this->render("success",['openId'=>$openId]);
                }

            }else{
                return $this->render("join-info",['model'=>$model,'imgs'=>$model->imgs]);
            }
        }
    }

    public function actionJoinInfo($Id = "")
    {

        $model = new VoteUserInfo();
        if($data = $model::findOne(['id'=>$Id])){
            return $this->render("join-info",['model'=>$data,'imgs'=>$data->imgs]);
        }

    }

    public function actionSuccess($openId=""){

        return $this->render("success",['openId'=>$openId]);
    }

    //点赞
    public function actionVoteClick($id,$openId){

        $modelClass = new VoteUserGood;
        $queryClass = new VoteUserInfo();
        $model = $modelClass::findOne(['vote_id'=>$id,"sayGood"=>$openId]);
        $query = $queryClass::findOne(['id'=>$id,'status'=>[1,2]]);

        if(empty($model)){
            $modelClass->vote_id = $id;
            $modelClass->sayGood = $openId;
            if($modelClass->save()){
                $query->num+=1;
                $query->update();
            }
            echo $query->num;
        }else{
            echo $query->num."<script>alert('您已经点赞');</script>";
        }

    }

    public function actionUploader(){


        $id = Yii::$app->request->post('id');
        $vote_info = $this->findModel($id);
        $data = $vote_info->upload();
        $html = <<<defo
        <img src=$data[path] data-id=$data[id] class="preview collecting-files-img">
defo;
        echo $html;
    }

    public function actionCenter($Id = ""){


        if($Id){
            $jsdk = new Jssdk();
            $signPackage = $jsdk->getSignPackage();
            $model = VoteUserInfo::findOne(['id'=>$Id,'status'=>[1,2]]);
            if(!empty($model)){
                $data = $this->toAndRank($model);
                $userInfo = $this->getSubscribe();
                if(!isset($userInfo['subscribe'])){
                    $userInfo['subscribe'] = 0;
                }
                return $this->render("joiner-center",['model'=>$model,"to"=>$data['to'],"rank"=>$data['rank'],'imgs'=>$model->imgs,'subscribe'=>$userInfo['subscribe'],'signPackage'=>$signPackage]);
            }
            $Id = Yii::$app->session->get('Id');
            return $this->redirect("join?Id=$Id&status=3");
        }
    }

    protected function toAndRank($info = Object::class){

        $model = new VoteUserInfo();
        $data = $model::find()->select("num")->where(["sex"=>$info['sex'],"status"=>[1,2,3]])->asArray()->all();
        arSort($data);
        $data2 = array();
        foreach($data as $list){
            array_push($data2,$list['num']);
        }
        $data3 = array_values(array_unique($data2));
        for($i = 0; $i < count($data3);$i++){

            if($data3[$i] == $info['num']){
                if($i != 0){
                    $to = $data3[$i-1]-$info['num'];
                    $data4 = array('to'=>$to,'rank'=>$i+1);
                    return $data4;
                }else{
                    $to = 0;
                    $data4 = array('to'=>$to,'rank'=>1);
                    return $data4;
                }
            }
        }
    }


    public function getAccessToken() {
        $option = ['appid'=>Yii::$app->params['appid'],'appsecret'=>Yii::$app->params['appsecret']];
        $this->cache = Yii::$app->cache;
        $data = $this->cache->get('access_token_js');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $option['appid'] . "&secret=" . $option['appsecret'];
            $res = json_decode($this->getData($token_access_url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->set('access_token_js',$access_token,7000);
            }
        } else {
            $access_token = $data;
        }
        return $access_token;
    }

    public function getData($url){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_ENCODING, 'gzip');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
    }


    protected function findModel($id)
    {
        if (($model = VoteUserInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
