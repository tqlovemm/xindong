<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/1/19
 * Time: 17:24
 */

namespace frontend\modules\test\controllers;

use frontend\modules\test\models\NewYearGood;
use frontend\modules\test\models\NewYearImg;
use frontend\modules\test\models\NewYearShare;
use Yii;
use yii\base\Object;
use yii\data\Pagination;
use yii\myhelper\Jssdk;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use frontend\modules\test\models\NewYear;
use yii\web\Session;

class NewYearController extends Controller
{

    public $enableCsrfValidation = false;
    public $cache;

    public function actionWeb()
    {
        $option = Yii::$app->params['appid'];
        $callback = "http://13loveme.com/test/new-year/callback";
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$option}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        return $this->redirect($url);
    }

    public function actionCallback(){

        $this->layout = "@app/themes/layouts/newy_header";
        $option = ['appID'=>Yii::$app->params['appid'],'appsecret'=>Yii::$app->params['appsecret']];
        $code =  Yii::$app->request->get("code");

        if(isset($code) && !empty($code)){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$option['appID']}&secret={$option['appsecret']}&code={$code}&grant_type=authorization_code";

            $access = file_get_contents($url);
            $result = json_decode($access);
            $openid = $result->openid;

            if($openid){
                $session = Yii::$app->session;
                if(!$session->isActive){
                    $session->open();
                }
                $session->set('openId',$openid);
                $model = new NewYear();

                if(empty($res = $model->find()->where(['openId'=>$openid])->one())){

                    $model->openId = $openid;

                    if(!$model->save()){
                        //return var_dump(array_values($model->getFirstErrors())[0]);
                        return var_dump("server's error，please connect us!");
                    }
                    $session->set('id',Yii::$app->db->getLastInsertID());
                }else{

                    $session->set('id',$res['id']);
                }
                return $this->redirect('woman');

            }else{
                return var_dump('请使用微信浏览');
            }

        }
    }

    //检查用户是否关注了公众号
    protected function getSubscribe(){

        $openId = Yii::$app->session->get('openId');
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$this->getAccessToken()}&openid={$openId}";
        $info = json_decode(file_get_contents($url),true);
        return $info;
    }

    public function actionMan(){

        $this->layout = "@app/themes/basic/layouts/newy_header";
        $data = NewYear::find()->where(['sex'=>0,'status'=>[2]])->orderBy('created_at desc');
        $data2 = clone($data);
        $page = new Pagination(['totalCount'=>$data2->count(),'pageSize'=>20]);
        $model = $data->offset($page->offset)->limit($page->limit)->all();
        $sub = $this->getSubscribe();
        if(!isset($sub['subscribe'])){
            $sub['subscribe'] = 0;
        }
        return $this->render('man',['model'=>$model,'pages'=>$page,'subscribe'=>$sub['subscribe']]);
    }

    public function actionWoman(){

        $this->layout = "@app/themes/basic/layouts/newy_header";
        $data = NewYear::find()->where(['sex'=>1,'status'=>[2]])->orderBy('created_at desc');
        $data2 = clone($data);
        $page = new Pagination(['totalCount'=>$data2->count(),'pageSize'=>20]);
        $model = $data->offset($page->offset)->limit($page->limit)->all();
        $subscribe = $this->getSubscribe();
        if(!isset($subscribe['subscribe'])){
            $subscribe['subscribe'] = 0;
        }
        return $this->render('woman',['model'=>$model,'pages'=>$page,'subscribe'=>$subscribe['subscribe']]);
    }

    public function actionTop(){

        $this->layout = "@app/themes/basic/layouts/newy_header2";
        $man = NewYear::find()
            ->joinWith('img')
            ->joinWith('goods')
            ->where(['sex'=>0,'pre_new_year.status'=>[2]])
            ->orderBy(' num desc ')
            ->limit(20)
            ->groupBy('pre_new_year.id')
            ->asArray()
            ->all();
        $woman = NewYear::find()
            ->joinWith('img')
            ->joinWith('goods')
            ->where(['sex'=>1,'pre_new_year.status'=>[2]])
            ->orderBy(' num desc ')
            ->limit(20)
            ->groupBy('pre_new_year.id')
            ->asArray()
            ->all();
        $subscribe = $this->getSubscribe();
        if(!isset($subscribe['subscribe'])){
            $subscribe['subscribe'] = 0;
        }
        return $this->render('top',['man'=>$man,'woman'=>$woman,'subscribe'=>$subscribe['subscribe']]);
    }

    public function actionCenter($id){

        $model = new NewYear();
        $info = $model::findOne(['id'=>$id]);
        if(!$info){
            return $this->redirect("web");
        }
        if( $info->status > 0){

            //第一次查看他人详情，弹出分享图
            $shareModel = new NewYearShare();
            $session = new Session();
            if(!$session->isActive){
                $session->open();
            }
            $isShare   = $shareModel::find()->select('id')->where(['who_share'=>$session->get('id'),'for_who'=>$id])->one();
            if(!$isShare['id']){
                $shareModel->who_share = $session->get('id');
                $shareModel->for_who = $id;
                $shareModel->save();
            }
            $data = $this->RankAndTo($info);
            $subscribe = $this->getSubscribe();
            if(!isset($subscribe['subscribe'])){
                $subscribe['subscribe'] = 0;
            }
            $jsdk = new Jssdk();
            $signPackage = $jsdk->getSignPackage();
            return $this->render('center',[
                'model' =>  $info,
                'imgs'  =>  $info->imgs,
                'to'    =>  $data['to'],
                'rank'  =>  $data['rank'],
                'subscribe' =>  $subscribe['subscribe'],
                'signPackage'   =>  $signPackage,
                'isShare'   =>  $isShare,
                ]
            );
        }else{
            return $this->redirect("join?id={$id}");
        }

    }

    public function actionShare($from,$for){

        $model = new NewYearShare();
        $isShare = $model::find()->where(['who_share'=>$from,'for_who'=>$for])->asArray()->one();
        if($isShare['id']){
            $id = $isShare['id'];
            $time = time();
            Yii::$app->db->createCommand("update pre_new_year_share set flag=1,updated_at = {$time} where id={$id}")->execute();
            return 2;
        }
        return 1;
    }

    public function actionJoin($id){

        $model = $this->findModel($id);
        if($model){
            if($model->status === 0 ){

                return $this->render('join',['model'=>$model,'imgs'=>$model->imgs]);
            }elseif(in_array($model->status,[1,2,3])){

                return $this->redirect("join-info?id={$id}");
            }
            return var_dump("server's error，please connect us!");
        }else{
            return var_dump("server's error，please connect us!");
        }

    }

    public function actionJoinInfo($id){

        $model = new NewYear();
        $info = $model::findOne(['id'=>$id]);
        if(!$info){
            return $this->redirect("web");
        }
        $data = Yii::$app->request->post();
        if($data){
            $model2 = $this->findModel($id);
            $model2->sex = $data['sex'];
            $model2->enounce = $data['declaration'];
            $model2->plateId = $data['number'];
            $model2->status = 1;
            if(!$model2->save()){
                return var_dump("server's error，please connect us!");
            }else{
                return $this->render("success",['id'=>$id]);
            }
        }
        return $this->render('join-info',['model'=>$info,'imgs'=>$info->imgs]);
    }

    //统计
    public function actionCenterInfo($id){

        $img = NewYearImg::find()->where(['da_id'=>$id])->one();
        $openID = NewYear::find()->where(['id'=>$id])->one();
        $sayGood = NewYearGood::find()
            ->where(['sayGood'=>$openID['openId']])
            ->orderBy('pre_new_year_good.created_at desc,pre_new_year_good.id desc')
            ->all();

        $getGood = (new NewYearGood())->find()
            //->select('pre_new_year_good.da_id,sayGood')
            ->where(['da_id'=>$id])
            ->orderBy('pre_new_year_good.created_at desc,pre_new_year_good.id desc')
            ->all();
        $rank = $this->RankAndTo($openID);
        return $this->render('center-info',[
            'img'=>$img,
            'info'=>$openID,
            'sayGood'=>$sayGood,
            'getGood'=>$getGood,
            'rank'  =>  $rank,

        ]);
    }


    public function actionFindOne($entry_number){

        $this->layout = "@app/themes/basic/layouts/newy_header";
        $subscribe = $this->getSubscribe();
        if (!isset($subscribe['subscribe'])) {
            $subscribe['subscribe'] = 0;
        }
        $model = NewYear::find()->where(['id' => $entry_number, 'status' => [1, 2]])->one();
        return $this->render('find-one',['model'=>$model,'subscribe'=>$subscribe['subscribe']]);
    }

    public function actionAbdClick($id,$openId){

        $modelClass1 = new NewYearGood();
        $modelClass2 = new NewYear();
        $model1 = $modelClass1::find()->where(['da_id'=>$id,'sayGood'=>$openId])->One();
        $model2 = $modelClass2::findOne(['id'=>$id,'status'=>[2]]);
        if(empty($model1)){

            $modelClass1->da_id = $id;
            $modelClass1->sayGood = $openId;
            $modelClass1->created_at = time();
            $modelClass1->updated_at = time();
            if($modelClass1->save()){
                $model2->num +=1;
                $model2->update();
            }
            echo $model2->num;
        }else{
            echo $model2->num."<script>alert('您已点赞过了')</script>";
        }
    }

    protected function RankAndTo($info = Object::class){

        $model = new NewYear();
        $data = $model::find()->select('num')->where(['sex'=>$info['sex'],'status'=>[2,3]])->asArray()->all();
        arSort($data);
        $data2 = array();
        foreach($data as $v){
            array_push($data2,$v['num']);
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

    public function actionSuccess($id){

        return $this->redirect("join-info?id=".$id);
    }


    public function actionClearOpenid(){


        Yii::$app->cache->delete('access_token_js');
    }

    public function actionUploader(){

        $id = Yii::$app->request->post('id');
        $vote_info = $this->findModel($id);
        $data = $vote_info->upload();
        $html = <<<defo
        <img src=$data[thumb] data-id=$data[id] class="preview collecting-files-img">
defo;
        echo $html;
    }

    public function getAccessToken() {
        $option = ['appID'=>Yii::$app->params['appid'],'appsecret'=>Yii::$app->params['appsecret']];
        $this->cache = Yii::$app->cache;
        $data = $this->cache->get('access_token_js');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . $option['appID'] . "&secret=" . $option['appsecret'];
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
        if (($model = NewYear::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
