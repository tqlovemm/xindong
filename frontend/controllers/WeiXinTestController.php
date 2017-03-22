<?php
namespace frontend\controllers;

use Yii;
use yii\base\Exception;
use yii\data\Pagination;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\myhelper\Jssdk;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use app\components\WxpayComponents;
use frontend\models\CollectingSeventeenFilesText;
use frontend\models\CollectingSeventeenWeiUser;
use frontend\modules\weixin\models\ScanWeimaRecord;


class WeiXinTestController extends Controller
{
    public  $postObj;
    public  $fromUsername;
    public  $toUsername;
    public  $keyword;
    public  $time;
    public $cache;
    public  $token;
    public  $signPackage;
    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['qun-fa', 'user-info','ticket'],

                'rules' => [
                    [
                        'actions' => ['qun-fa','user-info','create-menu','ticket'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],

        ];
    }
    public function actionIndex()
    {
        ob_clean();
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

            //第一次接入weixin api接口的时候
            echo  $echostr;
            exit;

        }else{
            $this->postObj = $this->postArr();
            $this->responseMsg();
        }

    }
    private function getAccessTokens() {
        $this->cache = Yii::$app->cache;
        $data = $this->cache->get('access_token_jss');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=wx0ac42806e83f308f&secret=d4624c36b6795d1d99dcf0547af5443d";
            $res = json_decode($this->getData($token_access_url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->set('access_token_jss',$access_token,7000);
            }
        } else {
            $access_token = $data;
        }
        return $access_token;
    }


    public function actionCjs(){

        Yii::$app->cache->delete('access_token_jss');
    }

    protected function http_post_data($url, $data_string) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json; charset=utf-8',
            'Content-Length: ' . strlen($data_string))
        );
        ob_start();
        curl_exec($ch);
        if (curl_errno($ch)) {
            $this->ErrorLogger('curl falied. Error Info: '.curl_error($ch));
        }
        $return_content = ob_get_contents();
        ob_end_clean();
        $return_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        return array($return_code, $return_content);
    }

    protected function DownLoadQr($url,$filestring){
        if($url == ""){
            return false;
        }
        $filename = $filestring.'.jpg';
        ob_start();
        readfile($url);
        $img=ob_get_contents();
        ob_end_clean();
        $size=strlen($img);
        $fp2=fopen('/uploads/qrcode/'.$filename,"a");
        if(fwrite($fp2,$img) === false){
            $this->ErrorLogger('dolwload image falied. Error Info: 无法写入图片');
            exit();
        }
        fclose($fp2);
        return './Uploads/qrcode/'.$filename;
    }

    private function ErrorLogger($errMsg){
        $logger = fopen('./ErrorLog.txt', 'a+');
        fwrite($logger, date('Y-m-d H:i:s')." Error Info : ".$errMsg."\r\n");
    }

    protected function postArr(){

        if(!isset($GLOBALS["HTTP_RAW_POST_DATA"])) return '';
        $postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
        $postObj = simplexml_load_string( $postArr );

        return $postObj;

    }
    public function actionGetMenu(){

        $url = "https://api.weixin.qq.com/cgi-bin/menu/get?access_token={$this->getAccessTokens()}";
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
                            'url'=>'http://mp.weixin.qq.com/s/IhEg7rG-ls01lFpBAGri6w',
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
                            "url"=>"http://13loveme.com/red",
                            "sub_button"=>[],

                        )
                    )
                ),
                array(
                    "type"=>"view",
                    "name"=>urlencode("加入平台"),
                    "url"=>"http://www.13loveme.com/contact",
                    "sub_button"=>[],
                ),
                array(
                    'name'=>urlencode("平台相关"),
                    'sub_button'=>array(
                        array(
                            "type"=>"view",
                            "name"=>urlencode("官方微博"),
                            "url"=>"http://weibo.com/13jiaoyoupt",
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
                            'name'=>urlencode("玩点神马"),
                            "url"=>"http://mp.weixin.qq.com/mp/homepage?__biz=MzAxMDIwMDIxMw==&hid=4&sn=422bb1b056dd63f8c212eb9fedcfbb05#wechat_redirect",
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

            if( strtolower($this->postObj->Event) == 'subscribe' ){

                $openid =  $this->postObj->FromUserName;
                $user_info = $this->getUserInfo($openid);
                $this->text($user_info);
            }

            if (strtolower($this->postObj->Event) == 'scan' ) {//扫码事件

                $openid =  $this->postObj->FromUserName;
                $user_info = $this->getUserInfo($openid);
                $this->text($user_info);
            }
        }

        //用户关键词回复
        if( strtolower($this->postObj->MsgType) == 'text' && in_array(trim($this->postObj->Content),['入口', '炮圈', '炮友', '约炮', '平台', '注册', '约', '会员', '加入', '入会', '费用', '交费', '客服','觅约', '啪']) ){

            $content = "<a href='http://13loveme.com/contact'>☞PAO圈.·入口☜</a>
撩起来！约一啪！";
            $this->text($content);
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
                case "17link":
                    $content = "http://17.tecclub.cn/bgadmin/verification";
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

    /**
     * @param $openid
     * @return string
     * 获取用户信息
     */
    protected function getUserInfo($openid){

        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->getAccessTokens()."&openid=".$openid."&lang=zh_CN";
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
     * @param $arr
     * 自定义菜单
     */
    protected function createMenu($arr){

        $data = urldecode(json_encode($arr));

        $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=".$this->getAccessTokens();

        $this->postData($url,$data);

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

        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$this->getAccessTokens();

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

        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->getAccessTokens()."&next_openid=$next_openid";
        $res = json_decode($this->getData($url),true);
        return $res;
    }


}
