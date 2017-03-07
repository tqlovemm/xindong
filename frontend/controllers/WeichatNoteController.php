<?php
namespace frontend\controllers;

use frontend\models\DinyueWeichatUserinfo;
use frontend\models\WeichatNote;
use frontend\models\WeichatNoteUserinfo;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;

class WeichatNoteController extends Controller
{
    const NOTE_NUMBER = 2785;

    public  $postObj;
    public  $fromUsername;
    public  $toUsername;
    public  $keyword;
    public  $time;
    public  $token;
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

        $token     = 'JqI8FXvh0gpjmeUxAIwKc6';
        $timestamp = Yii::$app->request->get('timestamp');
        $echostr   = Yii::$app->request->get('echostr');
        $signature = Yii::$app->request->get('signature');
        //形成数组，然后按字典序排序
        $array = array($nonce, $timestamp, $token);
        sort($array);
        //拼接成字符串,sha1加密 ，然后与signature进行校验
        $str = sha1( implode( $array ) );
        if( $str  == $signature && $echostr ){

            //第一次接入weixin api接口的时候
            echo  $echostr;
            exit;

        }else{
            $this->postObj = $this->postArr();
            $this->responseMsg();
        }

    }


    public function actionMedia(){

        var_dump(json_decode($this->getMediaList('image',0,10),true));
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
                    'name'=>urlencode("我要!"),
                    'sub_button'=>array(
                        array(

                            "type"=>"view",
                            "name"=>urlencode("我要交友"),
                            "url"=>"http://form.mikecrm.com/f.php?t=fpQC4B",
                            "sub_button"=>[],
                        ),

                        array(
                              "type"=>"click",
                           'name'=>urlencode("我要耍流氓"),
                           "key"=>"V1004_GOOD",

                        ),
                        array(
                            "type"=>"view",
                            'name'=>urlencode("往期文章"),
                            "url"=>"http://mp.weixin.qq.com/mp/homepage?__biz=MzI1MTEyMDI0Mw==&hid=1&sn=3081131fea43761e0a88e4a065dcfab6#wechat_redirect",
                            "sub_button"=>[],
                        )
                    )
                ),
                array(
                    "type"=>"view",
                    "name"=>urlencode("性福"),
                    "url"=>"http://www.13loveme.com/contact",
                    "sub_button"=>[],

                ),
                array(
                    'name'=>urlencode("约我"),
                    'sub_button'=>array(
                        array(
                            'type'=>'view',
                            'name'=>urlencode("介绍"),
                            "url"=>"http://mp.weixin.qq.com/s?__biz=MzI1MTEyMDI0Mw==&mid=2667463920&idx=2&sn=acad7015abc84c48701b27d8716d6042&scene=4#wechat_redirect",
                            "sub_button"=>[],
                        ),
                        array(
                            'type'=>'view',
                            'name'=>urlencode("密约"),
                            "url"=>"http://13loveme.com/date-past?title=%E6%B1%9F%E8%8B%8F&company=13pt",
                            "sub_button"=>[],
                        ),
                    )
                ),

            )
        );

        $this->createMenu($arr);

    }

    protected function responseMsg(){


        //2.处理消息类型，并设置回复类型和内容

        //判断该数据包是否是订阅的事件推送

        if( strtolower( $this->postObj->MsgType) == 'event'){
            //如果是关注 subscribe 事件


            if(strtolower($this->postObj->Event == 'unsubscribe')){

                $customer = DinyueWeichatUserinfo::findOne(['openid'=>$this->postObj->FromUserName]);
                $customer->delete();

            }elseif( strtolower($this->postObj->Event == 'subscribe') ){


                $model = new DinyueWeichatUserinfo();

                if(empty($model::findOne(['openid'=>$this->postObj->FromUserName]))){

                    $user_info = json_decode($this->getUserInfo($this->postObj->FromUserName),true);
                    $model->city = $user_info['city'];
                    $model->country = $user_info['country'];
                    $model->province = $user_info['province'];
                    $model->nickname = $user_info['nickname'];
                    $model->sex = $user_info['sex'];
                    $model->openid = $user_info['openid'];
                    $model->headimgurl = $user_info['headimgurl'];
                    $model->unionid = $user_info['unionid'];
                    $model->subscribe = $user_info['subscribe'];
                    $model->subscribe_time = $user_info['subscribe_time'];

                    $model->save();

                }


                $this->firstFocused();



            }elseif ($this->postObj->Event == 'CLICK') {//点击事件
                $EventKey = $this->postObj->EventKey;//菜单的自定义的key值，可以根据此值判断用户点击了什么内容，从而推送不同信息

                if($EventKey=='V1001_GOOD'){

                    $media_id = 'FIdAOXvuSobVgv3tbKb4JmdZvR9_256FLtNSrVN7kLc';
                    $this->image($media_id);
                    exit;
                }

                if($EventKey=='V1002_GOOD'){
                    $data = array(
                        array(
                            'title'=>"投稿步骤",
                            'description'=>"将投稿内容直接发送到后台",
                            'picUrl'=>'http://13loveme.com/images/weixin/0.jpg',
                            'url'=>'http://mp.weixin.qq.com/s?__biz=MzI1MTEyMDI0Mw==&mid=413443128&idx=1&sn=188cbe77cc04d226e7aadd068f653fd0&scene=18#wechat_redirect',
                        ),

                    );
                    $this->news($data);
                    exit;

                }

                if($EventKey=='V1003_GOOD'){

                    $data = array(
                        array(
                            'title'=>"十三平台简介",
                            'description'=>"欢迎来到全球最大的交友社区十三平台，我是13爷，我们为全球华人提供聊天，交友，约会等服务！",
                            'picUrl'=>'http://13loveme.com:82//uploads/heartweek/10000/heartweek4_14605147299867.jpg',
                            'url'=>'http://mp.weixin.qq.com/s?__biz=MzI1MTEyMDI0Mw==&mid=2667463920&idx=2&sn=acad7015abc84c48701b27d8716d6042&scene=4#wechat_redirect',
                        ),

                    );
                    $this->news($data);
                    exit;
                }

                if($EventKey=='V1004_GOOD'){
                    $data = "你所有羞羞的问题，都可以发给有点污的十三姨～对了，如果方便的话，请告诉我你是怎么发现我的~摸摸大";
                    $this->text($data);
                    exit;
                }

                exit;
            }
        }


        //用户发送t关键字的时候，回复一个单图文
        if( strtolower($this->postObj->MsgType) == 'text' && in_array(trim($this->postObj->Content),['污','污污','污污污']) ){

		$this->text("我有内涵，没有咪咪。你还爱我吗？");

            //注意：进行多图文发送时，子图文个数不能超过10个
        }else{

            switch( trim($this->postObj->Content) ){

                case "爱":
                    $this->text("我也爱你，来摸摸大！");
                    break;
                case "不爱":
                    $this->text("哦，那我不让你摸摸大！");
                    break;
            }
        }//if end
    }//reponseMsg end


    public function actionNoteIndex($type=1){

       $session = Yii::$app->session;
        if($session->isActive)
             $session->open();

        if(empty($session->get('13_openid'))){

             return $this->redirect('/wei-xin/note-check');
         }

        $query = new WeichatNote();
        $model = $query::findOne(self::NOTE_NUMBER);

        $photo = $model->getPhotos($type);

        shuffle($photo);

        $top = $model->getTop(6);

        $vote = (new Query())->select('nickname,headimgurl,count(*) as total')->from('pre_weichat_note_userinfo')->groupBy('openid')->having(['>','count(*)',1])->orderBy('count(*) desc')->limit(10)->all();

        return $this->render('note-index',['photo'=>$photo,'top'=>$top,'vote'=>$vote]);

    }
    public function actionTt(){

        $session = Yii::$app->session;
        if($session->isActive)
            $session->open();

        if(empty($session->get('13_openid'))){

            return $this->redirect('/wei-xin/note-check');
        }

    }

    public function actionEntrantsDetail($id){

        $session = Yii::$app->session;
        if($session->isActive)
            $session->open();

        if(empty($session->get('13_openid'))){

            return $this->redirect('/wei-xin/note-check');
        }

        $query = (new Query())->select('note_count')
            ->from('{{%weichat_note_content}}')
            ->where('album_id=:id', [':id' => self::NOTE_NUMBER])->all();
        arsort($query);

        $result = array();
        foreach ($query as $item){
            array_push($result,$item['note_count']);
        }

        $result = array_unique($result);

        $entrants= (new Query())->select('id,name,thumb,note_count')->from('{{%weichat_note_content}}')->where(['id'=>$id])->one();

        $entrants_detail = (new Query())->from('{{%weichat_note_content_detail}}')->where(['noteid'=>$id])->all();

        $result = array_values($result);

        foreach ($result as $key=>$list){

            if(($list==$entrants['note_count'])){
                if($key!=0){
                    $to = $result[$key-1]-$entrants['note_count'];
                    break;
                }else{
                    $to=0;
                    break;
                }
            }
        }

        return $this->render('entrants-detail',['entrants'=>$entrants,'entrants_detail'=>$entrants_detail,'to'=>$to]);
    }
    public function actionNoteClick($id){

        $session = Yii::$app->session;
        if($session->isActive)
            $session->open();
        $note_userinfo = new WeichatNoteUserinfo();
        $dinyue = new DinyueWeichatUserinfo();

        if(empty($note_userinfo::findOne(['unionid'=>$session->get('13_openid'),'noteid'=>self::NOTE_NUMBER,'status'=>1]))){

            //Yii::$app->db->createCommand("update pre_weichat_note_content set note_count=note_count+1 where id=$id")->execute();

            $count = (new Query())->select('note_count')->from('pre_weichat_note_content')->where(['id'=>$id])->one();
            /*$user_info = $dinyue::findOne(['unionid'=>$session->get('13_openid')]);

            $note_userinfo->noteid = self::NOTE_NUMBER;
            $note_userinfo->participantid = $id;
            $note_userinfo->city = $user_info['city'];
            $note_userinfo->country = $user_info['country'];
            $note_userinfo->province = $user_info['province'];
            $note_userinfo->nickname = $user_info['nickname'];
            $note_userinfo->sex = $user_info['sex'];
            $note_userinfo->openid = $user_info['openid'];
            $note_userinfo->headimgurl = $user_info['headimgurl'];
            $note_userinfo->unionid = $user_info['unionid'];
            $note_userinfo->subscribe = $user_info['subscribe'];
            $note_userinfo->subscribe_time = $user_info['subscribe_time'];

            $note_userinfo->save();
            */
            echo $count['note_count']."票<script>alert('投票已截止！异常数据将做删除处理！');</script>";

        }else{

            $count = (new Query())->select('note_count')->from('pre_weichat_note_content')->where(['id'=>$id])->one();

            echo $count['note_count']."票<script>alert('投票已截止！异常数据将做删除处理！');</script>";

        }
        
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
     * 首次关注
     */
    protected function firstFocused(){

       $content = "十三一直在这里等你上车！

在这里：有男女必备两性情感类内容和干货！你有什么羞羞的问题都可以留言哦！

<a href='http://mp.weixin.qq.com/s/hmPsFEhZhw4j7vRYOmlGzw'>☞十三 · 交友☜ </a>

<a href='http://mp.weixin.qq.com/mp/homepage?__biz=MzI1MTEyMDI0Mw==&hid=1&sn=3081131fea43761e0a88e4a065dcfab6#wechat_redirect'>☞X福 · 日常☜ </a>

<a href='http://www.13loveme.com/contact'>☞幸福 · 入口☜</a>";

        $this->text($content);

        exit;

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

        $data = Yii::$app->cache->get('access_token');

        if(!$data){

            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx7468c28e27022d39&secret=27b190a29b7ec62f82d9ad411849252e";

            $res = file_get_contents($token_access_url); //获取文件内容或获取网络请求的内容
            $result = json_decode($res, true); //接受一个 JSON 格式的字符串并且把它转换为 PHP 变量

            $access_token = $result['access_token'];
            Yii::$app->cache->set('access_token',$access_token,3600);

        }

        return Yii::$app->cache->get('access_token');

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

    public function actionTc(){


        $user = $this->getUserList();
        $model = new DinyueWeichatUserinfo();
        foreach ($user as $item){

            if(empty($model::findOne(['openid'=>$item]))){


                $user_info = json_decode($this->getUserInfo($item),true);

                Yii::$app->db->createCommand()->insert('pre_dinyue_weichat_userinfo', [

                    'subscribe'=>$user_info['subscribe'],
                    'openid'=>$user_info['openid'],
                    'nickname'=>$user_info['nickname'],
                    'sex'=>$user_info['sex'],
                    'city'=>$user_info['city'],
                    'province'=>$user_info['province'],
                    'country'=>$user_info['country'],
                    'headimgurl'=>$user_info['headimgurl'],
                    'subscribe_time'=>$user_info['subscribe_time'],
                    'unionid'=>$user_info['unionid']
                ])->execute();
            }
        }
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




}
