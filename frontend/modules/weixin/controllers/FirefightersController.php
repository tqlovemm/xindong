<?php

namespace frontend\modules\weixin\controllers;
use backend\models\User;
use backend\modules\bgadmin\models\BgadminGirlMember;
use backend\modules\bgadmin\models\BgadminMember;
use backend\modules\dating\models\Dating;
use backend\modules\dating\models\UserWeichatPush;
use backend\modules\exciting\models\OtherTextPic;
use common\components\SaveToLog;
use frontend\models\DatingSignup;
use frontend\modules\weixin\models\FirefightersSignUp;
use frontend\modules\weixin\models\SignupBefore;
use frontend\modules\weixin\models\UserWeichat;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\myhelper\AccessToken;
use yii\myhelper\Random;
use yii\web\Controller;
use Yii;
use \backend\modules\setting\models\AuthAssignment;

class FirefightersController extends Controller
{
    const NOTE_NUMBER = 10;
    public $access;
    public $access_token;
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['firefighters-sign', 'firefighters-query','index','callback','index-test','callback-test'],
                'rules' => [
                    [
                        'actions' => ['firefighters-sign','firefighters-query','index-test','callback-test'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionClearOpenid(){
        Yii::$app->cache->delete('access_token_js');
    }
    public function actionIndex(){

        $callback = "http://13loveme.com/weixin/firefighters/callback";
        $options = array('appid'=>Yii::$app->params['appid']);
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        return $this->redirect($url);
    }

    public function actionIndexTest(){

        $callback = "http://13loveme.com/weixin/firefighters/callback-test";
        $options = array('appid'=>Yii::$app->params['appid']);
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
        return $this->redirect($url);

    }

    public function actionCallbackTest(){

        $options = array(
            'appid'=>Yii::$app->params['appid'],
            'appsecret'=>Yii::$app->params['appsecret'],

        );
        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');

        if(!empty($data['code'])){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";
            $access = file_get_contents($url);
            $result = json_decode($access,true);
            $access_token = (new AccessToken())->getAccessToken();
            $openid = $result['openid'];
            $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token={$access_token}&openid={$openid}&lang=zh_CN";

            $getInfo = file_get_contents($url);
            $session = Yii::$app->session;
            if(!$session->isActive){
                $session->open();
            }

            $session->set('info',$getInfo);

            return $this->redirect('weichat-login-test');
        }
    }

    public function actionWeichatLoginTest(){

        $session = Yii::$app->session;
        if(!$session->isActive){
            $session->open();
        }
        $session_info = json_decode($session->get('info'),true);

        if($session_info['subscribe']==1){
            $openid = isset($session_info['openid'])?$session_info['openid']:'';
            $nickname = isset($session_info['nickname'])?$session_info['nickname']:'';
            $headimgurl = isset($session_info['headimgurl'])?$session_info['headimgurl']:'';
            $model = new UserWeichat();

            if(!empty($model::findOne(['openid'=>$openid]))){
                return $this->render('login-success',['title'=>'您的微信号已经绑定成功','model'=>$model::findOne(['openid'=>$openid])]);
            }

            $query = ArrayHelper::map(BgadminMember::find()->select('address_a')->where(['sex'=>0])->asArray()->all(),'address_a','address_a');
            unset($query['优质'],$query['女生档案']);
            $area = array_filter($query);
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->openid = $openid;
                    $model->nickname = $nickname;
                    $model->headimgurl = $headimgurl;
                    if($model->save()){
                        try{
                            SaveToLog::userBgRecord("微信认证,认证编号：{$model->number}，认证地区：{$model->address}");
                        }catch (Exception $e){
                            throw new ErrorException($e->getMessage());
                        }
                        return $this->render('login-success',['title'=>'恭喜您绑定成功','model'=>$model]);
                    }else{
                        return var_dump($model->errors);
                    }
                }
            }

            return $this->render('weicaht-login', [
                'model' => $model,'area'=>$area
            ]);

        }else{
            $session_info['subscribe'] = 0;
            return $this->render('weicaht-login', [
                'subscribe' => $session_info['subscribe']
            ]);


        }


    }


    public function actionCallback(){

        $options = array(
            'appid'=>Yii::$app->params['appid'],
            'appsecret'=>Yii::$app->params['appsecret'],

        );
        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');

        if(!empty($data['code'])){
            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";
            $access = file_get_contents($url);
            $result = json_decode($access,true);
            $access_token = $result['access_token'];
            $openid = $result['openid'];
            $url = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";
            $getInfo = file_get_contents($url);
            $nickname = !empty(json_decode($getInfo)->nickname)?json_decode($getInfo)->nickname:'nickname_null';
            $headimgurl = !empty(json_decode($getInfo)->headimgurl)?json_decode($getInfo)->headimgurl:'headimgurl_null';
            $userInfo = json_encode(array('nickname'=>$nickname,'headimgurl'=>$headimgurl));

            setcookie('renzhen_openid',$openid);
            setcookie('userInfo',$userInfo);

            return $this->redirect('weichat-login');
        }
    }

    public function actionWeichatLogin(){

        $openid = isset($_COOKIE['renzhen_openid'])?$_COOKIE['renzhen_openid']:'';
        $userInfo = isset($_COOKIE['userInfo'])?$_COOKIE['userInfo']:'';
        $model = new UserWeichat();
        $userInfo = json_decode($userInfo,true);
        if(!empty($model::findOne(['openid'=>$openid]))){

            if(User::getNumber(Yii::$app->user->id)!=$model::findOne(['openid'=>$openid])->number){
                echo "您认证的会员编号和您网站绑定的会员编号不一致，请联系客服核实后更改";
                exit();
            }

            return $this->render('login-success',['title'=>'您的微信号已经绑定成功','model'=>$model::findOne(['openid'=>$openid])]);
        }

        $query = ArrayHelper::map(BgadminMember::find()->select('address_a')->where(['sex'=>0])->asArray()->all(),'address_a','address_a');
        unset($query['优质'],$query['女生档案']);
        $area = array_filter($query);
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                $model->openid = $openid;
                $model->nickname = $userInfo['nickname'];
                $model->headimgurl = $userInfo['headimgurl'];
                if($model->save()){
                    try{
                        SaveToLog::userBgRecord("微信认证,认证编号：{$model->number}，认证地区：{$model->address}");
                    }catch (Exception $e){
                        throw new ErrorException($e->getMessage());
                    }
                    return $this->render('login-success',['title'=>'恭喜您绑定成功','model'=>$model]);
                }else{
                    return var_dump($model->errors);
                }
            }
        }

        return $this->render('weicaht-login', [
            'model' => $model,'area'=>$area
        ]);
    }

    public function actionSignupBefore($where='phone'){

        $model = new SignupBefore();
        $bgadmin = BgadminMember::find();
        $query = ArrayHelper::map($bgadmin->select('address_a')->where(['sex'=>0])->asArray()->all(),'address_a','address_a');
        unset($query['优质'],$query['女生档案']);
        $area = array_filter($query);
        if ($model->load(Yii::$app->request->post())) {
            if(!empty($invite=$model::findOne(['number'=>$model->number,'status'=>1]))){
                if($where=='13pt'){
                    return $this->redirect('/site/email-signup?invite='.$invite->invite_code);
                }else{
                    return $this->redirect('/signup?invite='.$invite->invite_code);
                }

            }
            $model->invite_code = $this->getInviteCode();
            $groupid = $bgadmin->select('vip,coin')->where(['number'=>$model->number])->one();

            $model->groupid = $groupid['vip'];
            $model->coin = $groupid['coin'];
            if ($model->validate()) {
                if($model->save()){

                    if($where=='13pt'){
                        return $this->redirect('/site/email-signup?invite='.$model->invite_code);
                    }else{
                        return $this->redirect('/signup?invite='.$model->invite_code);
                    }
                }else{
                    return var_dump($model->errors);
                }
            }
        }

        return $this->render('signup-before', [
            'model' => $model,'area'=>$area
        ]);
    }

    /*获取邀请码*/
    public function getInviteCode(){
        $invite = Random::get_random_code(10);
        if(empty(SignupBefore::findOne($invite))){
            return $invite;
        }else{
            self::getInviteCode();
        }
    }
    public function actionPullGirl($number,$id=0){
        $this->layout = '/basic';
        $dating = new Dating();
        $contents = $dating->getContentByNumber($number);
        $photos = $dating->getPhotoById($contents['id']);
        $r = BgadminGirlMember::findOne(['number'=>substr($number,0,strlen($number)-2)]);
        $member = !empty($r)?$r:BgadminGirlMember::findOne(['number'=>$number]);
        $remark = '';
        if($id!=0){
            $push = UserWeichatPush::findOne(['id'=>$id]);
            $remark = $push->remark;
            if(empty($push)){
                return '对不起!!该链接已经失效!!';
            }
            if(time()-$push->created_at>86400){
                return '对不起!!该链接已经失效!!';
            }
        }

        if(!empty($member)){
            $file = $member->getMemberText(0)->asArray()->one();
            if(!empty($file)){
                if(!empty($file['memberFiles'])){
                    return $this->render('pull-girl',['file'=>$file['memberFiles'][0]['path'],'contents'=>$contents,'photos'=>$photos,'remark'=>$remark]);
                }
            }
        }
    }
    public function actionPullFire($number,$id=0){
        $this->layout = '/basic';
        $contents = OtherTextPic::findOne(['number'=>$number]);
        $r = BgadminGirlMember::findOne(['number'=>substr($number,0,strlen($number)-2)]);
        $member = !empty($r)?$r:BgadminGirlMember::findOne(['number'=>$number]);

        //$member = BgadminGirlMember::findOne(['number'=>$number]);
        $remark = '';
        if($id!=0){
            $push = UserWeichatPush::findOne(['id'=>$id]);
            $remark = $push->remark;
            if(empty($push)){
                return '对不起!!该链接已经失效!!';
            }
            if(time()-$push->created_at>86400){
                return '对不起!!该链接已经失效!!';
            }
        }
        if(!empty($member)){
            $file = $member->getMemberText(0)->asArray()->one();
            if(!empty($file)){
                if(!empty($file['memberFiles'])){
                    return $this->render('pull-fire',['file'=>$file['memberFiles'][0]['path'],'contents'=>$contents,'remark'=>$remark]);
                }
            }
        }
    }


    public function actionFirefightersIndex($pid=null){
        $this->layout = '/basic';
        $modelClass = new OtherTextPic();

        $signup = DatingSignup::find()->select('like_id')->where(['user_id'=>Yii::$app->user->id])->column();
        $fire_signup = FirefightersSignUp::find()->select('number')->where(['user_id'=>Yii::$app->user->id])->column();
        $already = array_filter(array_unique(array_merge($signup,$fire_signup)));

        if(empty($pid)){
            $data = $modelClass::find()->where(['type'=>[3,4],'status'=>2])->andWhere(['not in','number',$already])->limit(12)->orderBy('pid desc')->asArray()->all();
            return $this->render('firefighters-index',['model'=>$data]);
        }else{
            $data = $modelClass::find()->where(['type'=>[3,4],'status'=>2,'pid'=>$pid])->andWhere(['not in','number',$already])->asArray()->all();
            return $this->render('firefighters-index2',['model'=>$data]);
        }
    }

    public function actionAjaxIndex($id){

        $modelClass = new OtherTextPic();

        $signup = DatingSignup::find()->select('like_id')->where(['user_id'=>Yii::$app->user->id])->column();
        $fire_signup = FirefightersSignUp::find()->select('number')->where(['user_id'=>Yii::$app->user->id])->column();
        $already = array_filter(array_unique(array_merge($signup,$fire_signup)));

        $model = $modelClass::find()->where(['type'=>[3,4],'status'=>2])->andWhere(['not in','number',$already])->andWhere('pid<'.$id)->limit(10)->orderBy('pid desc')->asArray()->all();

        if(!empty($model)){
            echo json_encode($model);
        }else{
            echo json_encode('null');
        }

    }

    public function actionFirefightersSign($id){

        $user_id = Yii::$app->user->id;
        $user = new User();
        $user_wx = UserWeichat::findOne(['number'=>$user->getNumber($user_id)]);
        if(empty($user_wx)||empty($user->getNumber($user_id))){
            return json_encode("login");
        }
        if(Yii::$app->user->identity->groupid>=2){
            $signClass = new FirefightersSignUp();
            $modelClass = new OtherTextPic();
            $model = $modelClass::findOne($id);

            $address = Yii::$app->db->createCommand("select address_1,address_2,address_3 from {{%user_profile}} where user_id=$user_id")->queryOne();
            $coin = Yii::$app->db->createCommand("select jiecao_coin from {{%user_data}} where user_id=$user_id")->queryOne();

            $addresses = array();
            if(!empty($address['address_1'])){

                $address_1 = array_values(json_decode($address['address_1'],true));
                $addresses = $address_1;
            }
            if(!empty($address['address_2'])){
                $address_2 = array_values(json_decode($address['address_2'],true));
                $addresses = array_merge($addresses,$address_2);
            }
            if(!empty($address['address_3'])){
                $address_3 = array_values(json_decode($address['address_3'],true));
                $addresses = array_merge($addresses,$address_3);
            }
            $addresses = array_filter($addresses);
            if(empty(User::getNumber(Yii::$app->user->id))){
                $result = '报名失败，平台未记录您的编号';
            }elseif(!$this->checkArea($model->name,$addresses)){
                $result = '报名失败，您所在地址不在妹子的需求范围之内';
            }elseif($model->coin>$coin['jiecao_coin']){
                $result = '报名失败，您的节操币不足';
            }else{
                if(empty($signClass::findOne(['sign_id'=>$id,'user_id'=>$user_id]))){

                    if($signClass::find()->where(['sign_id'=>$id])->count()>9){
                        $result = '报名已满';echo json_encode($result);exit;
                    }elseif($signClass::find()->where(['user_id'=>$user_id,'status'=>0])->count()>4){
                        $result = '您等待审核中的报名已达上限，请等待审核结束再报名';echo json_encode($result);exit;
                    }else{

                        $signClass->sign_id = $id;
                        $signClass->number = $model->number;
                        if($signClass->save()){
                            Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin-$model->coin where user_id=".$user_id)->execute();
                            $result = '报名成功';
                            try{
                                SaveToLog::userBgRecord("救火福利报名{$model->number},扣除节操币{$model->coin}");
                            }catch (Exception $e){
                                throw new ErrorException($e->getMessage());
                            }
                        }else{
                            $result = '系统错误';
                        }
                    }

                }else{
                    $result = '不可重复报名';
                }
            }
        }else{
            $result = '报名失败，您的会员等级不足';

        }
        echo json_encode($result);
    }

    public function checkArea($area,$areas){

        foreach ($areas as $item){

            if(stristr($item, $area) != false){
                return true;
            }
        }
        return false;
    }

    /**
     * 会员查询报名情况
     * @param $id
     * @return \yii\web\Response
     */
    public function actionFirefightersQuery($id){

         if(!empty(AuthAssignment::findOne(['user_id'=>Yii::$app->user->id]))){
             return $this->redirect(['firefighters-index','pid'=>$id]);
         }

        if(Yii::$app->user->identity->groupid>=2){
            $signClass = new FirefightersSignUp();
            $sign = $signClass::findOne(['sign_id'=>$id,'user_id'=>Yii::$app->user->id]);
            if(!empty($sign)){
                if($sign->status==1){
                    $result = '报名成功，女生二维码派发中';
                }elseif($sign->status==2){
                    $result = '对不起，女生已经有心仪的人了';
                }else{
                    $result = '请耐心等待，客服正在紧急帮您联系';
                }
            }else{
                $result = '对不起，您还没有报名';
            }
        }else{
            $result = '报名失败，您的会员等级不足';
        }
        echo json_encode($result);

    }
    public function actionSendTemp($openid,$url,$number){

        $data = array(
            "touser"=>$openid,
            "template_id"=>"sj6-k6LNiMH1n86EuDcy0BA5QJGfqaNThVtVN-i8W_w",
            "url"=>$url,
            "topcolor"=>"#FF0000",
            "data"=>array(
                "first"=> array(
                    "value"=>"十三平台觅约报名通知！",
                    "color"=>"#000"
                ),
                "keyword1"=>array(
                    "value"=>"对方女生编号：{$number}",
                    "color"=>"#000"
                ),
                "keyword2"=> array(
                    "value"=>"报名审核通过，点开即可获取对方联系方式",
                    "color"=>"#000"
                ),
                "keyword3"=> array(
                    "value"=>date('Y-m-d',time()),
                    "color"=>"#000"
                ),
                "remark"=>array(
                    "value"=>"感谢您的参与！",
                    "color"=>"#000"
                )
            )
        );
        var_dump($this->sendTemp($data));
    }

    /**
     *
     * @param $data
     * @return mixed|string
     * 发送模板消息
     */
    public function sendTemp($data){

        $this->access = new AccessToken();
        $this->access_token = $this->access->getAccessToken();
        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->access_token;
        return $this->postData($url,json_encode($data));
    }

    public function postData($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }

}
