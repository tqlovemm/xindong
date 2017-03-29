<?php
namespace frontend\modules\weixin\controllers;

use backend\modules\bgadmin\models\KunsheWeima;
use common\components\SaveToLog;
use frontend\modules\weixin\models\KunsheWeimaFollowCount;
use frontend\modules\weixin\models\KunsheWeimaRecord;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;

class KunSheController extends Controller
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
        $token     = "kunshe";
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
        $data = $this->cache->get('access_token_ks');
        if (empty($data)) {
            $token_access_url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=" . Yii::$app->params['id_ks'] . "&secret=" . Yii::$app->params['secret_ks'];
            $res = json_decode($this->getData($token_access_url));
            $access_token = $res->access_token;
            if ($access_token) {
                $this->cache->set('access_token_ks',$access_token,7000);
            }
        } else {
            $access_token = $data;
        }
        return $access_token;
    }
    public function actionCat(){
        Yii::$app->cache->delete('access_token_ks');
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
                    'name'=>urlencode("幸福入口"),
                    'sub_button'=>array(
                        array(
                            'type'=>'click',
                            'name'=>urlencode("男生入口"),
                            "key"=> "V1001_GOOD",
                        ),
                        array(
                            'type'=>'click',
                            'name'=>urlencode("女生入口"),
                            "key"=> "V1002_GOOD",
                        ),
                    )
                ),
                array(
                    'name'=>urlencode("撩一撩"),
                    'sub_button'=>array(
                        array(
                            "type"=>"view",
                            "name"=>urlencode("SM|西檬之家"),
                            "url"=>"https://mp.weixin.qq.com/s?__biz=MzI2OTQ3OTA1NA==&mid=2247483859&idx=3&sn=4de9b46e0e7e88543d0c00cb0aeb53a0&chksm=eadefc32dda97524d0a7adb860559c937752d3601d49cf71e2cd8fef878dde4d8c8bb9919476&scene=18#rd",
                            "sub_button"=>[],

                        ), array(
                            "type"=>"click",
                            "name"=>urlencode("跑圈 | 十三平台"),
                            "key"=> "V1003_GOOD",

                        ),
                        array(
                            'type'=>'click',
                            'name'=>urlencode("聊sao | 神秘三角"),
                            "key"=> "V1004_GOOD",
                        ),
                    )
                )
            )
        );

        $this->createMenu($arr);

    }
    public function setTag($openid,$tagid){
        $url = "https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token=".$this->getAccessTokens();
        $data = array("openid_list"=>["$openid"],"tagid"=>$tagid);
        $this->postData($url,json_encode($data));
    }
    protected function responseMsg(){
        if( strtolower( $this->postObj->MsgType) == 'event'){
            $openid =  $this->postObj->FromUserName;
            $model = new KunsheWeimaRecord();
            $followModel = new KunsheWeimaFollowCount();
            if( strtolower($this->postObj->Event) == 'subscribe' ){

                $user_info = json_decode($this->getUserInfo($openid));
                try{
                    if (!empty($this->postObj->EventKey)) {
                        $key = explode('_', $this->postObj->EventKey);
                        if(isset($key[1])){
                            $model->scene_id = $key[1];
                        }else{
                            $model->scene_id = 0;
                        }
                        $model->openid = "{$openid}";
                        $model->headimgurl = "$user_info->headimgurl";
                        $model->subscribe_time = $user_info->subscribe_time;
                        $model->country = $user_info->country;
                        $model->province = $user_info->province;
                        $model->city = $user_info->city;
                        $model->sex = $user_info->sex;
                        $model->nickname= $user_info->nickname;
                        $model->type = 1;
                        if(empty($model::find()->where(['openid'=>$openid,'status'=>1])->andWhere('created_at!='.strtotime('today'))->asArray()->one())) {
                            $model->status = 1;//新用户关注
                        }else{
                            $model->status = 3;//老用户关注
                        }
                        if($model->save()){
                            $follow = $followModel::findOne(['created_at'=>strtotime('today'),'sence_id'=>$model->scene_id]);
                            if(!empty($follow)){
                                if($model->status == 1){
                                    $follow->new_subscribe+=1;
                                }else{
                                    $follow->old_subscribe+=1;
                                }
                                if(!$follow->update()){
                                    SaveToLog::log($follow->errors,'wm.log');
                                }
                            }else{
                                $followModel->sence_id = $model->scene_id;
                                if($model->status == 1){
                                    $followModel->new_subscribe=1;
                                }else{
                                    $followModel->old_subscribe=1;
                                }
                                if(!$followModel->save()){
                                    SaveToLog::log($followModel->errors,'wm.log');
                                }
                            }
                            $weima = KunsheWeima::findOne($model->scene_id);
                            $this->setTag($openid,$weima->tag_id);
                        }else{
                            SaveToLog::log($model->errors,'we13.log');
                        }
                    }

                }catch (\Exception $e){
                    SaveToLog::log($e->getMessage(),'we13.log');
                }finally{

                    $content = "欢迎来到全国最大的情趣社区联盟mo-得意
拥有众多文化社交平台
在这里你可以尽情展现自己！

【十三交友平台】
<a href=\"https://mp.weixin.qq.com/s?__biz=MzI1MTEyMDI0Mw==&mid=2667464720&idx=3&sn=017159a5989c3d238a254cf959b225a8&chksm=f2fd370cc58abe1aacb776cb925c64ba02658e217640d8d627875695af251c2ba3b692364f6f#rd\">☞ 全球最大华人高端交友社区☜ </a> 
只有来了才知道其中的乐趣！

【西檬之家】
<a href=\"http://mp.weixin.qq.com/s/0Q_DAaB6Qg8q0pzN7nG1JA\">☞ SM亚文化圈层社区☜ </a>
你懂得，老司机聚集地！

【江浙沪豫高端线下交友】
<a href=\"http://mp.weixin.qq.com/s/6zyGq4Om2gldkq9Pao97mw\">☞ 华中及长三角最大线下高端交友聚会社群☜ </a>
区域化交友，交流更方便！";
                    $this->text($content);
                }
            }
            if( strtolower($this->postObj->Event) == 'unsubscribe' ){
                $already_today = $model::find()->where(['openid'=>$openid])->andWhere('created_at='.strtotime('today'))->orderBy('subscribe_time desc')->one();
                $already_yesterday = $model::find()->where(['openid'=>$openid])->andWhere('created_at!='.strtotime('today'))->orderBy('subscribe_time desc')->one();
                if(!empty($already_today)){

                    $follow = $followModel::findOne(['created_at'=>strtotime('today'),'sence_id'=>$already_today->scene_id]);
                    if(!empty($follow)){
                        $follow->new_unsubscribe+=1;
                        if(!$follow->update()){
                            SaveToLog::log($model->errors,'wm.log');
                        }
                    }else{
                        $followModel->sence_id = $already_today->scene_id;
                        $followModel->new_unsubscribe=1;
                        if(!$followModel->save()){
                            SaveToLog::log($model->errors,'wm.log');
                        }
                    }

                    $model::updateAll(['type'=>0],['openid'=>$openid,'type'=>1]);

                }elseif(!empty($already_yesterday)){

                    $follow = $followModel::findOne(['created_at'=>strtotime('today'),'sence_id'=>$already_yesterday->scene_id]);
                    if(!empty($follow)){
                        $follow->old_unsubscribe+=1;
                        if(!$follow->update()){
                            SaveToLog::log($model->errors,'wm.log');
                        }
                    }else{
                        $followModel->sence_id = $already_yesterday->scene_id;
                        $followModel->old_unsubscribe=1;
                        if(!$followModel->save()){
                            SaveToLog::log($model->errors,'wm.log');
                        }
                    }
                    $model::updateAll(['type'=>0],['openid'=>$openid,'type'=>1]);
                }
            }
            if( strtolower($this->postObj->Event) == 'click' ){
                $EventKey = $this->postObj->EventKey;
                if($EventKey=='V1001_GOOD'){
                    $media_id = 'O6eLs8-Y0QQbm638hdjTsn4VEnrtMwU25BtI2_ec8Z8';
                    $this->image($media_id);
                    exit;
                }elseif($EventKey=='V1002_GOOD'){
                    $media_id = 'O6eLs8-Y0QQbm638hdjTsp2XzF2JsEc1rSJyze5CyBM';
                    $this->image($media_id);
                    exit;
                }elseif($EventKey=='V1003_GOOD'){
                    $data = array(
                        array(
                            'title'=>"你一定想不到交友还可以这么玩！",
                            'description'=>"重新定义yp的新方式！",
                            'picUrl'=>'http://mmbiz.qpic.cn/mmbiz_jpg/ynej4OHDOHXUpRSP77SQKdkwNlpOmxaCFUmMFTbqLdYuMjPRvXSnhevUSufCcmqL2yqQ5S9YBRn1YVMxc1R2lg/0?wx_fmt=jpeg',
                            'url'=>'http://mp.weixin.qq.com/s/Co8ASHDCwP9M72Hx9ekM7w',
                        ),
                    );
                    $this->news($data);
                    exit;
                }elseif($EventKey=='V1004_GOOD'){
                    $data = array(
                        array(
                            'title'=>"同城交友聊Sao，我们是认真的！",
                            'description'=>"让交友约会离你更近一点！",
                            'picUrl'=>'http://mmbiz.qpic.cn/mmbiz_jpg/ynej4OHDOHXUpRSP77SQKdkwNlpOmxaC64B794HryVsHP5w1H6VVcEiaWfX6D0NnaAPrF7ZB4xJnwZXQrNtN5TQ/0?wx_fmt=jpeg',
                            'url'=>'http://mp.weixin.qq.com/s/W-AuCbS3MkMo3rk6hjXBzw',
                        ),
                    );
                    $this->news($data);
                    exit;
                }
            }
        }
    }//reponseMsg end
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
    protected function getMedia(){

        $url = "https://api.weixin.qq.com/cgi-bin/material/get_material?access_token=".$this->getAccessTokens();
        $data = file_get_contents($url);
        return $data;
    }
    public function actionMedia(){

        echo "<pre>";
        return var_dump($this->getMediaList('image',0,15));

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
        $url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=".$this->getAccessTokens();

        $data = json_encode($arr);

        return $this->postData($url,$data);

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
