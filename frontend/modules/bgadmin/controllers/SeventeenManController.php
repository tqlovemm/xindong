<?php
namespace frontend\modules\bgadmin\controllers;
use app\components\WxpayComponents;
use backend\modules\seventeen\models\SeventeenWeiUser;
use frontend\models\CollectingSeventeenFilesText;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\myhelper\Jssdk;
use yii\web\Controller;
use Yii;
use yii\web\ForbiddenHttpException;

class SeventeenManController extends Controller
{

    public $signPackage;
    public $openid;
    public $nickname;
    public $headimgurl;
    
    public function actionChoiceAddress(){

        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
        if($userModel->status==0){
            return $this->render("judge-vip",['userModel'=>$userModel]);
        }elseif($userModel->status==1){
            $expire = time()-($userModel->updated_at+$userModel->expire*3600);
            if($expire>0){
                return $this->render("judge-vip",['userModel'=>$userModel]);
            }
        }
        if(!empty($userModel)&&empty($userModel->address)){
            $model = (new Query())->select('id,address_province')->from('pre_collecting_17_files_text')->all();
            $area = array_unique(array_filter(ArrayHelper::map($model,'id','address_province')));
            return $this->render('choice-address',['area_data'=>$area,'signPackage'=>$this->signPackage]);
        }else{
            return $this->redirect('seventeen-area');
        }
    }

    public function actionSeventeenArea($area=null){
        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
        if($userModel->status==0){
            return $this->render("judge-vip",['userModel'=>$userModel]);
        }elseif($userModel->status==1){
            $expire = time()-($userModel->updated_at+$userModel->expire*3600);
            if($expire>0){
                return $this->render("judge-vip",['userModel'=>$userModel]);
            }
        }
        if(empty($area)){
            return $this->redirect('private-address');
        }

        $this->layout = "/basic";
        $cookie = Yii::$app->request->cookies;

        if(empty($userModel->address)){
            $userModel->address = $area.'，';
            $userModel->update();
        }

        $count = (new Query())->from('pre_collecting_17_addlist')->where(['flag'=>$cookie->get('flag_17')])->count();

        $data = CollectingSeventeenFilesText::find()->with('imgs')->where(['address_province'=>$area])->andWhere(['>','status',0])->orderBy("created_at desc");
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '8']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('seventeen-list',[
            'query' => $model,
            'pages' => $pages,
            'count'=>$count,
            'flag'=>$cookie->get('flag_17'),
            'signPackage'=>$this->signPackage
        ]);

    }



    public function actionSeventeenCode(){
        if($this->judgeCookie()){
            $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
            if(!empty($userModel)){
                return $this->redirect('choice-address');
            }

        }
        $callback = "http://13loveme.com/bgadmin/seventeen-man/seventeen";
        $options = array('appid'=>Yii::$app->params['appid']);
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        return $this->redirect($url);
    }
    public function actionSeventeen(){
        if($this->judgeCookie()){
            $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
            if(!empty($userModel)){
                return $this->redirect('choice-address');
            }
        }
        $options = array('appid'=>Yii::$app->params['appid'], 'appsecret'=>Yii::$app->params['appsecret']);
        $data['code'] = Yii::$app->request->get('code');

        if(!empty($data['code'])) {

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";
            $result = json_decode(file_get_contents($url));
            $openid = $result->openid;
            $access_token = $result->access_token;
            $url_user_info = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $user_info = json_decode(file_get_contents($url_user_info),true);
            $headimgurl = !empty($user_info['headimgurl'])?$user_info['headimgurl']:"null";
            $nickname = !empty($user_info['nickname'])?$user_info['nickname']:"null";

            if (!empty($openid)) {
                $query = SeventeenWeiUser::findOne(['openid'=>$openid]);
                if(empty($query)){
                    $query = new SeventeenWeiUser();
                    $query->openid = $openid;
                    $query->nickname = $nickname;
                    $query->headimgurl = $headimgurl;
                    $query->save();

                }
                $this->addCookie('openid',$openid);
                $this->addCookie('nickname',$nickname);
                $this->addCookie('headimgurl',$headimgurl);

                return $this->redirect('choice-address');

            }else{

                throw new ForbiddenHttpException('非法访问');
            }
        }

    }


    public function actionAddAddress(){
        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
        if($userModel->status==0){
            return $this->render("judge-vip",['userModel'=>$userModel]);
        }elseif($userModel->status==1){
            $expire = time()-($userModel->updated_at+$userModel->expire*3600);
            if($expire>0){
                return $this->render("judge-vip",['userModel'=>$userModel]);
            }
        }
        $this->layout = "/basic";

        $model = (new Query())->select('id,address_province')->from('pre_collecting_17_files_text')->all();
        $area = array_unique(array_filter(ArrayHelper::map($model,'id','address_province')));

        return $this->render('add-address',['area_data'=>$area,'already_areas'=>array_filter(explode('，',$userModel->address)),'openid'=>$this->openid,'signPackage'=>$this->signPackage]);

    }

    public function actionRemoveCookie(){
        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('flag_17');
        return $this->redirect("seventeen-code");

    }
    public function actionAddAddressWxpay($area){

        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $this->layout = "/basic";
        $areas = array_unique(array_filter(explode(',',$area)));

        $order_number = '4'.time().rand(10000,99999);
        $attach = array('user_id'=>0,'groupid'=>$this->openid,'area'=>urlencode($area));
        $wxpay = new WxpayComponents();
        $wxpay->Wxpay('十七会员添加开通新地区',$order_number,50000*count($areas),json_encode($attach),'add_address');
    }

    public function actionPrivateAddress(){
        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
        if($userModel->status==0){
            return $this->render("judge-vip",['userModel'=>$userModel]);
        }elseif($userModel->status==1){
            $expire = time()-($userModel->updated_at+$userModel->expire*3600);
            if($expire>0){
                return $this->render("judge-vip",['userModel'=>$userModel]);
            }
        }
        if(empty($userModel->address)){
            return $this->redirect('choice-address');
        }
        return $this->render('private-address',['user_id'=>$userModel->id,'already_areas'=>array_filter(explode('，',$userModel->address)),'signPackage'=>$this->signPackage]);

    }

    /**
     * @param $id
     * @return mixed
     */

    public function actionAjaxAddSeventeen($id)
    {
        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
        if($userModel->status==0){
            return "0"."<script>alert('对不起您还没有报名权限，请联系客服开通！')</script>";
        }elseif($userModel->status==1){
            $expire = time()-($userModel->updated_at+$userModel->expire*3600);
            if($expire>0){
                return "0"."<script>alert('对不起您还没有报名权限，请联系客服开通！')</script>";
            }
        }
        $cookie = Yii::$app->request->cookies;
        $query = (new Query())->from('pre_collecting_17_addlist')->where(['flag'=>$cookie->get('flag_17'),'member_id'=>$id])->one();
        if(empty($query)){

            Yii::$app->db->createCommand()->insert('pre_collecting_17_addlist',[
                'openid'=>$this->openid,
                'member_id'=>$id,
                'flag'=>$cookie->get('flag_17'),
                'created_at'=>time(),
                'updated_at'=>time()
            ])->execute();

        }else{

            $add_count = (new Query())->from('pre_collecting_17_addlist')->where(['flag'=>$cookie->get('flag_17')])->count();
            return $add_count."<script>alert('已经加入后宫！')</script>";
        }

        $add_count = (new Query())->from('pre_collecting_17_addlist')->where(['flag'=>$cookie->get('flag_17')])->count();
        return $add_count;
    }

    public function actionListDetail($flag){

        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
        if($userModel->status==0){
            return $this->render("judge-vip",['userModel'=>$userModel]);
        }elseif($userModel->status==1){
            $expire = time()-($userModel->updated_at+$userModel->expire*3600);
            if($expire>0){
                return $this->render("judge-vip",['userModel'=>$userModel]);
            }
        }
        $this->layout = "/basic";

        $query = (new Query())->select('member_id')->from('pre_collecting_17_addlist')->where(['flag'=>$flag])->column();
        $model= CollectingSeventeenFilesText::find()->joinWith('imgs')->where(['pre_collecting_17_files_text.id'=>$query])->orderBy('created_at desc')->asArray()->all();

        return $this->render('list-detail',['query'=>$model,'signPackage'=>$this->signPackage,'flag'=>$flag]);
    }

    public function actionShareList($flag){
        $query = (new Query())->select('member_id')->from('pre_collecting_17_addlist')->where(['flag'=>$flag])->column();
        $model= CollectingSeventeenFilesText::find()->joinWith('imgs')->where(['pre_collecting_17_files_text.id'=>$query])->asArray()->all();
        return $this->render('share-list',['query'=>$model]);
    }


    public function actionSeventeenSingle($id){

        if(!$this->judgeCookie()){
            return $this->redirect('seventeen-code');
        }
        $userModel = SeventeenWeiUser::findOne(['openid'=>$this->openid]);
        if($userModel->status==0){
            return $this->render("judge-vip",['userModel'=>$userModel]);
        }elseif($userModel->status==1){
            $expire = time()-($userModel->updated_at+$userModel->expire*3600);
            if($expire>0){
                return $this->render("judge-vip",['userModel'=>$userModel]);
            }
        }
        $this->layout = '/basic';
        $model = CollectingSeventeenFilesText::findOne($id);
        return $this->render('seventeen-single',['model'=>$model,'imgs'=>$model->imgs,'signPackage'=>$this->signPackage]);
    }
    protected function judgeCookie(){
        $cookie = Yii::$app->request->cookies;
        $this->openid = $cookie->getValue('openid');
        $this->nickname = $cookie->getValue('nickname');
        $this->headimgurl = $cookie->getValue('headimgurl');
        if(!empty($this->openid)&&!empty($this->nickname)&&!empty($this->headimgurl)){
            $jssdk = new Jssdk();
            $this->signPackage = $jssdk->getSignPackage();
            $this->addCookie("flag_17",md5(time()).rand(1000,9999));

            return true;
        }
        return false;
    }
    protected function addCookie($cookie_name,$cookie_value){

        $cookies = Yii::$app->response->cookies;
        $cookie = Yii::$app->request->cookies;
        if(empty($cookie->get($cookie_name))){
            $cookies->add(new \yii\web\Cookie([
                'name' => $cookie_name,
                'value' => $cookie_value,
                'expire'=>time()+3600*24*365,
            ]));
        }

    }

}