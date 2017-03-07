<?php
namespace frontend\controllers;

use app\components\WxpayComponents;
use common\models\WeiLogin;
use common\models\WeiUser;
use common\models\Wuser;
use frontend\models\CollectingSeventeenFilesText;
use frontend\models\CollectingSeventeenWeiUser;
use frontend\models\DinyueWeichatUserinfo;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\myhelper\Jssdk;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class VoteController extends Controller
{
    public  $postObj;
    public  $fromUsername;
    public  $toUsername;
    public  $keyword;
    public  $time;
    public  $token;
    public  $signPackage;
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['qun-fa', 'user-info'],

                'rules' => [
                    [
                        'actions' => ['qun-fa','user-info','create-menu'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }
    public function actionIndex()
    {

        $nonce     = Yii::$app->request->get('nonce');

        $token     = "weixin";
        $timestamp = Yii::$app->request->get('timestamp');
        $echostr   = Yii::$app->request->get('echostr');
        $signature = Yii::$app->request->get('signature');
        //形成数组，然后按字典序排序
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str  == $signature && $echostr ){
            ob_clean();
            //第一次接入weixin api接口的时候
            echo  $echostr;
            exit;

        }else{
            $this->postObj = $this->postArr();
            $this->responseMsg();
        }

    }

    public function actionC(){

        Yii::$app->cache->delete('access_token');

    }


    protected function postArr(){

        if(!isset($GLOBALS["HTTP_RAW_POST_DATA"])) return '';
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string( $postArr );

        return $postObj;

    }
    public function actionGetMenu(){

        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$this->getAccessToken()}";
        $data = $this->getData($url);
        $get_menu = json_decode($data,true);

        return var_dump($get_menu);
    }

    public function actionCreateMenu(){

        $arr = array(
            'button' =>array(
                array(
                    'name'=>urlencode("新人必看"),
                    'sub_button'=>array(
                        array(
                            'type'=>'view',
                            'name'=>urlencode("平台简介"),
                            'url'=>'http://mp.weixin.qq.com/s?__biz=MzAxMDIwMDIxMw==&mid=503683187&idx=1&sn=9e750223ff76edbcdc1a2a044e09a12d&scene=18#wechat_redirect',
                            "sub_button"=>[],
                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode("官方网站"),
                            'url'=>'http://13loveme.com/',
                            "sub_button"=>[],
                        ),
                        array(
                            "type"=>"view",
                            "name"=>urlencode("往日觅约"),
                            "url"=>"http://13loveme.com:8888/red",
                            "sub_button"=>[],

                        )
                    )
                ),
                array(
                    'name'=>urlencode("加入平台"),
                    'sub_button'=>array(
                        array(
                            'type'=>'view',
                            'name'=>urlencode("男生通道"),
                            "url"=>"http://13loveme.com/heart-slide/21?top=bottom&version=1.0.1",
                            "sub_button"=>[],
                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode("女生通道"),
                            "url"=>"http://13loveme.com/heart-slide/19?top=bottom",
                            "sub_button"=>[],
                        ),
                    )
                ),
                array(
                    'name'=>urlencode("平台相关"),
                    'sub_button'=>array(
                        array(
                            "type"=>"view",
                            "name"=>urlencode("官方微博"),
                            "url"=>"http://weibo.com/13jiaoyou?is_all=1",
                            "sub_button"=>[],

                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode("会员分布"),
                            "url"=>"http://13loveme.com/heart/34?top=bottom",
                            "sub_button"=>[],
                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode("免责声明"),
                            "url"=>"http://13loveme.com/attention/disclaimers?top=bottom",
                            "sub_button"=>[],
                        )
                    )
                )
            )
        );

        $this->createMenu($arr);

    }

    protected function responseMsg(){

        //2.处理消息类型，并设置回复类型和内容

        //判断该数据包是否是订阅的事件推送
        if( strtolower( $this->postObj->MsgType) == 'event'){
            //如果是关注 subscribe 事件
            if( strtolower($this->postObj->Event == 'subscribe') ){

                $arr = array(
                    array(
                        'title'=>'十三平台简介',
                        'description'=>"十三平台简介",
                        'picUrl'=>'http://13loveme.com:82//uploads/heartweek/10000/heartweek4_14605147299867.jpg',
                        'url'=>'http://mp.weixin.qq.com/s?__biz=MzAxMDIwMDIxMw==&mid=503683187&idx=1&sn=9e750223ff76edbcdc1a2a044e09a12d&scene=1&srcid=0803UhTPhlG4Zn2syB7QcX3I#wechat_redirect',
                    ),

                );

                $this->news($arr);

                exit;

            }elseif ($this->postObj->Event == 'CLICK') {//点击事件

                $EventKey = $this->postObj->EventKey;//菜单的自定义的key值，可以根据此值判断用户点击了什么内容，从而推送不同信息

                exit;
            }
        }


        //用户发送t关键字的时候，回复一个单图文
        if( strtolower($this->postObj->MsgType) == 'text' && in_array(trim($this->postObj->Content),['护士','南宁','护士门','南宁护士','护士事件','护士门事件']) ){

            $this->text("南宁护士门事件 地址：https://pan.baidu.com/s/1i5PjKcl 提取码：utdg 解压密码：1024");

        }else{

            switch( trim($this->postObj->Content) ){

                case "深夜":
                    $data = array(
                        array(
                            'title'=>"解锁男女“小黑屋”",
                            'description'=>"深夜性趣部落：深夜小游戏，虽然无节操无下限，但很有料哦！",
                            'picUrl'=>'http://13loveme.com/images/weixin/688526311119687689.jpg',
                            'url'=>'http://www.13loveme.com/heart/38?top=bottom',
                        ),

                    );
                    $this->news($data);
                    break;

                case 1307:

                    $user_id = (new Query())->select('user_id')->from('{{%weichat_openid}}')->where(['openid'=>$this->postObj->FromUserName])->one();
                    $user_id = $user_id['user_id'];
                    if(empty($user_id)){

                        $data = array(
                            array(
                                'title'=>'十三平台官网账号绑定',
                                'description'=>"十三平台官网账号绑定登录,绑定成功后再次回复1307即可查询个人信息",
                                'picUrl'=>'http://13loveme.com/images/weixin/201408191115389390.jpg',
                                'url'=>'http://13loveme.com/wei-xin/web',
                            ),

                        );
                        $this->news($data);

                    }else{

                        $credit = (new Query())->select("levels,viscosity,lan_skills,sex_skills,appearance")->from('{{%credit_value}}')->where(['user_id'=>$user_id])->one();
                        $credit = array_sum($credit);
                        $userData = (new Query())->select("jiecao_coin")->from('{{%user_data}}')->where(['user_id'=>$user_id])->one();
                        $recharge = (new Query())->select("sum(number)")->from('{{%recharge_record}}')->where(['user_id'=>$user_id,'subject'=>1])->orWhere(['user_id'=>$user_id,'subject'=>2])->column();
                        $user = (new Query())->select("username,groupid")->from('{{%user}}')->where(['id'=>$user_id])->one();
                        $groupid = $user['groupid'];
                        switch($groupid){

                            case 0:
                                $level = "管理员";break;
                            case 1:
                                $level = "网站会员";break;
                            case 2:
                                $level = "普通会员";break;
                            case 3:
                                $level = "高端会员";break;
                            case 4:
                                $level = "至尊会员";break;
                            case 5:
                                $level = "私人订制";break;
                            default:
                                $level = "不存在";break;
                        }
                        $data = array(
                            "touser"=>"{$this->postObj->FromUserName}",
                            "template_id"=>"9e113Rx9Z7U2RrFI0Gb7Trd8RsuIHxhMFW38rXygaa8",
                            "url"=>"http://weixin.qq.com/download",
                            "topcolor"=>"#FF0000",
                            "data"=>array(
                                "first"=> array(
                                    "value"=>"十三平台会员信息查询！",
                                    "color"=>"#ccc"
                                ),
                                "keyword1"=>array(
                                    "value"=>"{$user['username']}",
                                    "color"=>"#ccc"
                                ),
                                "keyword2"=> array(
                                    "value"=>"{$level}",
                                    "color"=>"#ccc"
                                ),
                                "keyword3"=> array(
                                    "value"=>"{$userData['jiecao_coin']}节操币",
                                    "color"=>"#ccc"
                                ),
                                "keyword4"=> array(
                                    "value"=>"总计{$recharge[0]}元",
                                    "color"=>"#ccc"
                                ),
                                "keyword5"=> array(
                                    "value"=>"{$credit}",
                                    "color"=>"#ccc"
                                ),
                                "remark"=>array(
                                    "value"=>"感谢您的支持！",
                                    "color"=>"#ccc"
                                )
                            )
                        );
                        $this->sendTemp($data);
                    }

                    break;
                default:

                    $content = "男生请加微信客服：shisan-3，QQ号：8495167;女生请加微信客服：bb-shisan";
                    $this->text($content);

                    break;
            }
        }//if end
    }//reponseMsg end

    /*get code*/
    protected function getCode($callback = "http://13loveme.com/wei-xin/callback"){

        $options = array(
            'appid'=>Yii::$app->params['appid'],
        );

        $callback = urlencode($callback);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

        return $this->redirect($url);

    }

    public function actionSeventeenCode($flag){

        $callback = "http://13loveme.com/wei-xin/seventeen?flag=$flag";
        $options = array('appid'=>Yii::$app->params['appid']);
        $callback = urlencode($callback);
        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
        return $this->redirect($url);

    }


    public function actionSeventeen($flag){

        $options = array('appid'=>Yii::$app->params['appid'], 'appsecret'=>Yii::$app->params['appsecret']);
        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');

        if(!empty($data['code'])) {

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";
            $access = file_get_contents($url);
            $result = json_decode($access);
            $openid = $result->openid;
            $session = Yii::$app->session;
            if (!$session->isActive){
                $session->open();
            }

            if (!empty($openid)) {

                $session->set('17_openid', $openid);

                $query = (new Query())->from('pre_collecting_17_wei_user')->where(['flag'=>$flag])->one();
                if(!empty($query)&&empty($query['openid'])){

                    $save_openid = CollectingSeventeenWeiUser::findOne(['flag'=>$flag]);

                    $save_openid->openid = $openid;
                    $save_openid->status = 0;
                    $save_openid->save();

                }elseif($query['openid']==$openid){

                    return $this->redirect('choice-address');

                }else{

                    throw new ForbiddenHttpException('非法访问');
                }

                return $this->redirect('choice-address');

            }else{

                throw new ForbiddenHttpException('非法访问');
            }

        }

    }
    public function actionChoiceAddress(){

        $query = $this->sessionCheck();

        if(!empty($query['address'])){
            $area = explode('，',$query['address']);
            return $this->redirect('seventeen-list?area='.$area[0]);
        }

        $model = (new Query())->select('id,address_province')->from('pre_collecting_17_files_text')->all();
        $area = array_unique(array_filter(ArrayHelper::map($model,'id','address_province')));
        return $this->render('choice-address',['area_data'=>$area,'signPackage'=>$this->signPackage]);

    }
    public function actionAddAddress(){

        $this->layout = "basic";
        // $query = array('openid'=>50,'id'=>50,'address'=>50);
        $query = $this->sessionCheck();
        $model = (new Query())->select('id,address_province')->from('pre_collecting_17_files_text')->all();
        $area = array_unique(array_filter(ArrayHelper::map($model,'id','address_province')));

        return $this->render('add-address',['area_data'=>$area,'query'=>$query,'openid'=>$query['openid'],'signPackage'=>$this->signPackage]);

    }

    public function actionAddAddressWxpay($area){
        $this->layout = "basic";
        $query = $this->sessionCheck();

        $areas = array_unique(array_filter(explode(',',$area)));

        $order_number = '4'.time().rand(10000,99999);
        $attach = array('user_id'=>0,'groupid'=>$query['openid'],'area'=>urlencode($area));
        $wxpay = new WxpayComponents();
        $wxpay->Wxpay('十七会员添加开通新地区',$order_number,50000*count($areas),json_encode($attach),'add_address');
    }

    public function actionPrivateAddress(){

        $query = $this->sessionCheck();
        if(empty($query['address'])){
            return $this->redirect('choice-address?area');
        }
        return $this->render('private-address',['model'=>$query,'signPackage'=>$this->signPackage]);

    }

    /**
     * @param $id
     * @return mixed
     */

    public function actionAjaxAddSeventeen($id)
    {
        $cookie = Yii::$app->request->cookies;
        $q = $this->sessionCheck();
        $query = (new Query())->from('pre_collecting_17_addlist')->where(['flag'=>$cookie->get('flag_17'),'member_id'=>$id])->one();
        if(empty($query)){

            Yii::$app->db->createCommand()->insert('pre_collecting_17_addlist',[
                'openid'=>$q['openid'],
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
        $this->layout = "basic";
        $f = $this->sessionCheck();
        $query = (new Query())->select('member_id')->from('pre_collecting_17_addlist')->where(['flag'=>$flag])->column();
        $model= CollectingSeventeenFilesText::find()->joinWith('imgs')->where(['pre_collecting_17_files_text.id'=>$query])->asArray()->all();

        return $this->render('list-detail',['query'=>$model,'signPackage'=>$this->signPackage,'flag'=>$flag,'flags'=>$f['flag']]);
    }

    public function actionShareList($flag){

        $query = (new Query())->select('member_id')->from('pre_collecting_17_addlist')->where(['flag'=>$flag])->column();
        $model= CollectingSeventeenFilesText::find()->joinWith('imgs')->where(['pre_collecting_17_files_text.id'=>$query])->asArray()->all();
        return $this->render('share-list',['query'=>$model]);
    }

    public function actionSeventeenHistory(){
        $this->layout = "basic";
        //$query = $this->sessionCheck();
        $query['openid'] = "olQJss1mkh6-2xNlHwPKKh1IEFLQ";
        $model = (new Query())->select('GROUP_CONCAT(member_id) as member_id,created_at')->from('pre_collecting_17_addlist')->where(['openid'=>$query['openid']])->groupBy('flag')->orderBy('created_at desc');
        $photos = \Yii::$app->tools->Pagination($model);

        return $this->render('seventeen-history',[
            'model'=>$photos['result'],
            'pages' => $photos['pages'],
        ]);

    }
    public function actionRemoveCookie(){

        $query = $this->sessionCheck();
        $cookies = Yii::$app->response->cookies;
        $cookies->remove('flag_17');



        return $this->redirect("seventeen-code?flag=".$query['flag']);

    }
    public function actionSeventeenList($area){

        $this->layout = "basic";
        $cookie = Yii::$app->request->cookies;
        $query = $this->sessionCheck();

        if(empty($query['address'])){
            $save_openid = CollectingSeventeenWeiUser::findOne(['openid'=>$query['openid']]);
            $save_openid->address = $area.'，';
            $save_openid->update();
        }else{
            $areas = array_filter(explode('，',$query['address']));
            if(!in_array($area,$areas)){
                throw new ForbiddenHttpException('非法访问');
            }
        }

        $count = (new Query())->from('pre_collecting_17_addlist')->where(['flag'=>$cookie->get('flag_17')])->count();
        $model= CollectingSeventeenFilesText::find()->joinWith('imgs')->where(['address_province'=>$area])->andWhere(['>','status',0])->asArray()->all();
        return $this->render('seventeen-list',[
            'query' => $model,'count'=>$count,'flag'=>$cookie->get('flag_17'),'signPackage'=>$this->signPackage
        ]);

    }

    public function actionSeventeenSingle($id){

        $this->layout = 'basic';
        $this->sessionCheck();

        $model = CollectingSeventeenFilesText::findOne($id);
        return $this->render('seventeen-single',['model'=>$model,'imgs'=>$model->imgs,'signPackage'=>$this->signPackage]);

    }

    public function sessionCheck(){

        $cookies = Yii::$app->response->cookies;
        $cookie = Yii::$app->request->cookies;

        $jssdk = new Jssdk();
        $this->signPackage = $jssdk->getSignPackage();

        if(empty($cookie->get('flag_17'))){
            $cookies->add(new \yii\web\Cookie([
                'name' => 'flag_17',
                'value' => md5(time()).rand(10000,99999),
                'expire'=>time()+3600*24*365,
            ]));
        }

        $session = Yii::$app->session;
        if (!$session->isActive){
            $session->open();
        }
        $query = (new Query())->from('pre_collecting_17_wei_user')->where(['openid'=>$session->get('17_openid')])->one();
        if(empty($session->get('17_openid'))||empty($query)){
            return $this->redirect('seventeen-code');
        }


        $query['openid'] = $session->get('17_openid');

        return $query;

    }

    public function actionWeiFlop(){

        $callback = "http://13loveme.com/wei-xin/weiflopuserinfo";
        $this->getCode($callback);

    }

    public function actionNoteCheck(){
        $callback = "http://13loveme.com/wei-xin/weichat-info";
        $this->getCode($callback);
    }
    public function actionWeichatInfo(){

        $options = array(
            'appid'=>Yii::$app->params['appid'],
            'appsecret'=>Yii::$app->params['appsecret'],

        );
        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');

        if(!empty($data['code'])){

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";

            $access = file_get_contents($url);

            $result = json_decode($access);

            $access_token = $result->access_token;

            $openid = $result->openid;

            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

            $userInfo = json_decode(file_get_contents($url2),true);

            $model = new DinyueWeichatUserinfo();


            $session = Yii::$app->session;
            if($session->isActive)
                $session->open();

            if(!empty($userInfo['unionid'])){

                $session->set('13_openid',$userInfo['unionid']);
            }

            $noteUrl = '/weichat-note/note-index';//投票地址

            return $this->redirect($noteUrl);

        }

    }
    public function actionClear(){
        $cookie = Yii::$app->request->cookies;
        var_dump($cookie->getValue('flag2'));
    }
    public function actionWeiflopuserinfo(){

        $options = array(
            'appid'=>Yii::$app->params['appid'],
            'appsecret'=>Yii::$app->params['appsecret'],

        );
        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');

        if(!empty($data['code'])){

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";

            $access = file_get_contents($url);

            $result = json_decode($access);

            $openid = $result->openid;

            $noteUrl = 'http://13loveme.com:8888/w-flop/area?openid='.$openid;


            return var_dump($noteUrl);
            return $this->redirect($noteUrl);

        }

    }
    /**
     * web授权登录
     */
    public function actionWeb(){

        $options = array(
            'appid'=>Yii::$app->params['appid'],
        );

        $callback = "http://13loveme.com/wei-xin/callback";

        $callback = urlencode($callback);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

        return $this->redirect($url);

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

            $result = json_decode($access);

            $access_token = $result->access_token;

            $openid = $result->openid;

            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";

            $userInfo = file_get_contents($url2);

            if(!empty($userInfo)){

                return $this->redirect(['login','userInfo'=>$userInfo]);

            }
        }


    }
    public function actionLogin(){

        $model = new LoginForm();

        $userInfo = json_decode(Yii::$app->request->get('userInfo'));

        if(empty($userInfo)){

            throw new ForbiddenHttpException;
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            $user_id = Yii::$app->user->id;

            $query = (new Query())->select("user_id")->from('{{%weichat_openid}}')->where(['user_id'=>$user_id])->one();

            if(!empty($query)){

                Yii::$app->db->createCommand()->update("{{%weichat_openid}}",[
                    'openid'=>$userInfo->openid,
                    'nickname'=>$userInfo->nickname,
                    'language'=>$userInfo->language,
                    'sex'=>$userInfo->sex,
                    'city'=>$userInfo->city,
                    'province'=>$userInfo->province,
                    'country'=>$userInfo->country,
                    'headimg'=>$userInfo->headimgurl,

                ],'user_id='.$user_id)->execute();

            }else{

                Yii::$app->db->createCommand()->insert("{{%weichat_openid}}",[
                    'user_id'=>$user_id,
                    'openid'=>$userInfo->openid,
                    'nickname'=>$userInfo->nickname,
                    'language'=>$userInfo->language,
                    'sex'=>$userInfo->sex,
                    'city'=>$userInfo->city,
                    'province'=>$userInfo->province,
                    'country'=>$userInfo->country,
                    'headimg'=>$userInfo->headimgurl,
                ])->execute();

            }

            return $this->redirect('success');

        } else {

            return $this->render('wei-login', [
                'model' => $model,
            ]);
        }

    }
    public function actionSuccess(){


        return $this->render('success');

    }


    /**
     * @param $openid
     * @return string
     * 获取用户信息
     */
    protected function getUserInfo($openid){

        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getAccessToken()."&openid=".$openid."&lang=zh_CN";
        $data = file_get_contents($url);
        return $data;
    }

    protected function getMedia(){

        $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$this->getAccessToken();
        $data = file_get_contents($url);
        return $data;
    }

    /**
     * @param $data
     * 各种模板消息
     */
    protected function news($data){

        $time     = time();
        $template = "<xml>
							<ToUserName><![CDATA[%s]]></ToUserName>
							<FromUserName><![CDATA[%s]]></FromUserName>
							<CreateTime>%s</CreateTime>
							<MsgType><![CDATA[%s]]></MsgType>
							<ArticleCount>".count($data)."</ArticleCount>
							<Articles>";
        foreach($data as $k=>$v){
            $template .="<item>
                        <Title><![CDATA[".$v['title']."]]></Title>
                        <Description><![CDATA[".$v['description']."]]></Description>
                        <PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
                        <Url><![CDATA[".$v['url']."]]></Url>
                        </item>";
        }
        $template .="</Articles>
							</xml>";
        $info     = sprintf($template, $this->postObj->FromUserName, $this->postObj->ToUserName, $time, 'news');
        echo $info;
        exit;

    }
    protected function text($data){

        $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Content><![CDATA[%s]]></Content>
                        </xml>";
        //注意模板中的中括号 不能少 也不能多

        echo sprintf($template, $this->postObj->FromUserName, $this->postObj->ToUserName, time(), 'text', $data);

    }
    protected function image($media_id){

        $template = "
                        <xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Image>
                            <MediaId><![CDATA[%s]]></MediaId>
                        </Image>
                        </xml>
                    ";
        echo sprintf($template, $this->postObj->FromUserName, $this->postObj->ToUserName, time(), 'image' , $media_id);

    }
    protected function voice($media_id){

        $template = "<xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Voice>
                        <MediaId><![CDATA[%s]]></MediaId>
                        </Voice>
                        </xml>";
        echo sprintf($template, $this->postObj->FromUserName, $this->postObj->ToUserName, time(), 'voice', $media_id);

    }
    protected function video($data){

        $template = "
                        <xml>
                        <ToUserName><![CDATA[%s]]></ToUserName>
                        <FromUserName><![CDATA[%s]]></FromUserName>
                        <CreateTime>%s</CreateTime>
                        <MsgType><![CDATA[%s]]></MsgType>
                        <Video>
                        <MediaId><![CDATA[%s]]></MediaId>
                        <Title><![CDATA[%s]]></Title>
                        <Description><![CDATA[%s]]></Description>
                        </Video>
                    </xml>
                    ";
        echo sprintf($template, $this->postObj->FromUserName, $this->postObj->ToUserName ,time(), 'video', $data['media_id'], $data['title'], $data['description']);

    }
    protected function music($data){

        $template = "<xml>
                    <ToUserName><![CDATA[%s]]></ToUserName>
                    <FromUserName><![CDATA[%s]]></FromUserName>
                    <CreateTime>%s</CreateTime>
                    <MsgType><![CDATA[%s]]></MsgType>
                    <Music>
                    <Title><![CDATA[%s]]></Title>
                    <Description><![CDATA[%s]]></Description>
                    <MusicUrl><![CDATA[%s]]></MusicUrl>
                    <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
                    <ThumbMediaId><![CDATA[%s]]></ThumbMediaId>
                    </Music>
                    </xml>";

        echo sprintf($template, $this->postObj->FromUserName, $this->postObj->ToUserName, time(), 'music', $data['title'] , $data['description'], $data['music_url'] , $data['hq_music_url'] , $data['thumb_media_id']);

    }


    /**
     * @param $type
     * @param int $start
     * @param int $number
     * @return mixed|string
     * 获取素材列表
     */
    protected function getMediaList($type,$start=0,$number=10){

        $arr = array(
            "type"=>$type,
            "offset"=>$start,
            "count"=>$number
        );
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->getAccessToken();

        $data = json_encode($arr);

        return $this->postData($url,$data);

    }

    /**
     * @param $arr
     * 自定义菜单
     */
    protected function createMenu($arr){

        $data = urldecode(json_encode($arr));

        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getAccessToken();

        $this->postData($url,$data);

    }

    /**获取token*/
    public function getAccessToken(){

        $data = Yii::$app->cache->get('access_token1');

        if(!$data){

            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . Yii::$app->params['appid'] . "&secret=" . Yii::$app->params['appsecret'];

            $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
            $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量

            $access_token = $result['access_token'];
            Yii::$app->cache->set('access_token1',$access_token,3600);

        }

        return Yii::$app->cache->get('access_token1');

    }

    /**
     * @param $url
     * @return mixed
     * get请求
     */
    protected function getData($url){
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

    /**
     * @param $url
     * @param $data
     * @return mixed|string
     * post请求
     */
    protected function postData($url,$data){
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

    /**
     * @param $data
     * @return mixed|string
     * 发送模板消息
     */
    public function sendTemp($data){

        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->getAccessToken();

        return $this->postData($url,json_encode($data));

    }

    /**获取用户列表*/
    protected function getUserList(){

        $res = $this->userList();
        $count = floor($res['total']/10000);

        $result = $res['data']['openid'];

        for($i=0;$i<$count;$i++){

            $next_openid = $res['next_openid'];

            $result = array_merge($result,$this->userList($next_openid)['data']['openid']);
        }


        return $result;
    }
    protected function userList($next_openid=''){

        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->getAccessToken()."&next_openid=$next_openid";
        $res = json_decode($this->getData($url),true);
        return $res;
    }

    /**
     * @param $like_id
     * @return \yii\web\Response
     */
    public function actionSendToCs($like_id){


        $userInfoList = array(Yii::$app->params['service_openid']);
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$this->getAccessToken();
        foreach($userInfoList as $val){

            $datas = array(

                "touser"=>"$val",

                "msgtype"=>"text",

                "text"=>array(
                    "content"=>"http://www.13loveme.com/wei-web/web-openid?like_id={$like_id}",
                ),
            );
            $data = '{
              "touser":"'.$val.'",
              "msgtype":"text",
              "text":
              {
                "content":"http://13loveme.com/wei-web/ds-gu?like_id={$like_id}"
              }
            }';

            $this->postData($url,json_encode($datas));
        }
        return $this->redirect("/wei-web/success");

    }

    private  function sendMsgToAll(){
        //$userInfoList = $this->getUserList();olQJss81V3N-ldlc0XlQJkg0fRKo//olQJss1mkh6-2xNlHwPKKh1IEFLQ
        $userInfoList = array('olQJss1mkh6-2xNlHwPKKh1IEFLQ');
        $url = "https://api.weixin.qq.com/cgi-bin/message/mass/preview?access_token=".$this->getAccessToken();
        foreach($userInfoList as $val){
            $data = '{
               "touser":"'.$val.'",
               "mpnews":{"media_id":"E0tHD_vFyBttc0lGRk33TGHkHnV7KSv240pmjfS_veA"},
               "msgtype":"mpnews"
            }';
            return $this->postData($url,$data);
        }
    }

}
