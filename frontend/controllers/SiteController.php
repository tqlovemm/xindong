<?php
namespace frontend\controllers;
use common\components\SaveToLog;
use frontend\models\CollectingSeventeenFilesText;
use frontend\models\ContactIpLimits;
use frontend\modules\weixin\models\FirefightersSignUp;
use frontend\modules\weixin\models\UserWeichat;
use Yii;
use app\components\SendTemplateSMS;
use backend\modules\exciting\models\Exciting;
use backend\modules\dating\models\Dating;
use backend\modules\exciting\models\OtherTextPic;
use backend\modules\exciting\models\Website;
use backend\modules\setting\models\AuthAssignment;
use common\models\User;
use frontend\models\DatingSignup;
use frontend\models\PasswordResetMobileForm;
use frontend\models\RechargeRecord;
use frontend\models\UserData;
use frontend\modules\weixin\models\SendMobileCode;
use frontend\modules\weixin\models\SignupBefore;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\Pagination;
use frontend\models\Encryption;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use yii\base\InvalidParamException;
use yii\myhelper\AccessToken;
use yii\myhelper\Helper;
use yii\web\BadRequestHttpException;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;
use yii\myhelper\Easemob;
use yii\myhelper\Address;
class SiteController extends BaseController
{
    public  $enableCsrfValidation = false;

    /**
     * @return array
     * 登陆验证
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup','encryption','dating-signup','dating','dating-signup-rewirte'],
                'rules' => [
                    [
                        'actions' => ['signup', 'develop', 'help','encryption'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout','encryption','dating-signup','dating-signup-rewirte'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }
    /**
     * @return string
     * 网站首页
     */
    public function actionIndex()
    {
        $this->layout = '/basic';

        $wx_validate = false;

        if(!Yii::$app->user->isGuest){
            $weiUser = new UserWeichat();
            $user_number = \backend\models\User::getNumber(Yii::$app->user->id);
            if(!empty($user_number)){
                if(empty($weiUser::findOne(['number'=>$user_number]))){
                    $session = Yii::$app->session;
                    if(empty($session->get('wx_validate'))){
                        $wx_validate = true;
                        $session->set('wx_validate','wx_validate');
                    }
                }
            }
        }

        return $this->render('index',['wx_validate'=>$wx_validate]);
    }
    /**
     * @return string
     * 服务
     */
    public function actionServices(){

        $this->layout = 'basic';
        return $this->render('13services');

    }

    /**
     * @return string
     * 心动故事
     */
    public function actionExciting(){

        $this->layout = 'basic';

        return $this->render('datinghear');

    }

    /**
     * @param $status
     * @param $data
     * ajax获取心动故事
     */
    public function actionMore($status,$data){

        $last = $_POST['last'];
        $amount = $_POST['amount'];

        $query = Yii::$app->db->createCommand("select * from {{%$data}} WHERE status=$status order by id desc limit $last,$amount")->queryAll();

        foreach($query as $row) {
            $title = $row['title']==1?'<span class="red">【女生反馈】</span>':'<span class="blue">【男生反馈】</span>';
            $content = Helper::truncate_utf8_string($row['content'],35);
            $sayList[] = array(
                'img-hear' => "<img class='img-responsive center-block' src='{$row["url"]}'>",
                'title-hear' => $title,
                'content-hear' => $content,
                'all-hear'=>'
                    <a href="hear-view/'.$row["id"].'?url='.AccessToken::antiBlocking().'">
                        <div class="row">
                            <div class="col-xs-9">
                                '.$title.'
                                <spant class="content-hear">'.$content.'</spant>
                            </div>
                            <div class="col-xs-3 img-hear"><img class=\'img-responsive center-block\' src="'.$row["url"].'" title="'.$row['content'].'" alt="'.$row['content'].'"></div>
                        </div>
                    </a>

                '
            );
        }
        echo json_encode($sayList);

    }

    /**
     * @param $id
     * @return string
     *
     * 心动故事内容
     */
    public function actionHearView($id){

        $this->layout='/basic';
        $exciting = new Exciting();
        $photos = $exciting->getPhoto($id);
        $weekly_id = $id;
        $comment = $exciting->getComment($id);

        return $this->render('hear-view',[
            'photos'=>$photos,
            'weekly_id'=>$weekly_id,
            'comments'=>$comment,

        ]);
    }

    /**
     * @param int $type
     * @param string $number
     * @param string $where
     * @return string
     * 今日密约
     */
    public function actionDateToday($type=1001,$number='',$where=""){

        $this->layout='/basic';
        if($where==""){
            $this->encryption(Yii::$app->request->hostInfo.Yii::$app->request->url);
        }

        if($type==1001){
            $query = Dating::find()->select('id,number,title,title2,title3,content,url,created_at,avatar,worth,cover_id')->where(['status' => 2])->andWhere(['in','cover_id',[0,-1]])->orderBy('updated_at DESC');
            $pages = new Pagination(['totalCount' => 25,'pageSize' => '8']);

        }else{

            $query = Dating::find()->select('id,number,title,title2,title3,content,url,created_at,avatar,worth,cover_id')->where(['like','number',$number])->andWhere(['in','cover_id',[0,-1]])->orderBy('updated_at DESC');
            $countQuery = clone $query;
            $pages = new Pagination(['totalCount' => count($countQuery),'pageSize' => '8']);
        }

        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();
        $jiecao_coin = UserData::find()->select('jiecao_coin')->where(['user_id'=>Yii::$app->user->id])->asArray()->one();

        $groupid = empty(Yii::$app->user->identity->groupid)?null:Yii::$app->user->identity->groupid;
        if(!empty($groupid)&&$groupid==2){
            $cookie = Yii::$app->request->cookies;
            if(empty($cookie->get('gd_zz_sy'))){
                $cookies = Yii::$app->response->cookies;
                $cookies->add(new \yii\web\Cookie([
                    'name' => 'gd_zz_sy',
                    'value' => 'gd_zz_sy',
                ]));
            }
        }

        return $this->render('date-today',['model'=>$models,'pages' => $pages,'total'=>$jiecao_coin['jiecao_coin']]);

    }

    /**
     * @param $title
     * @param string $where
     * @return string
     * @throws NotFoundHttpException
     *
     * 往日觅约
     */

    public function actionDatePast($title,$where=""){

        $this->layout='/basic';
        /*if($where==""){
            $this->encryption(Yii::$app->request->hostInfo.Yii::$app->request->url);
        }*/


        $query = Dating::find()->select('id,number,title,content,url,created_at,avatar,worth,cover_id')->where(['status' => 2,'title'=>$title])->andWhere(['in','cover_id',[0,-1]])->orderBy('updated_at desc');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit(10)
            ->all();

        if (($model = Dating::findOne(['status'=>2])) !== null) {
            $mod =  $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在。');
        }

        $jiecao_coin = UserData::find()->select('jiecao_coin')->where(['user_id'=>Yii::$app->user->id])->asArray()->one();
        return $this->render('date-past',['model'=>$models,'pages' => $pages,'mod'=>$mod,'total'=>$jiecao_coin['jiecao_coin']]);

    }

    /**
     * @param $id
     * @param string $where
     * @return string
     *
     * 觅约内容
     */

    public function actionDateView($id,$where=""){

        $this->layout='/basic';
        if($where==""){
            $this->encryption(Yii::$app->request->hostInfo.Yii::$app->request->url);
        }
        $dating = new Dating();
        $area = $dating->getArea($id);
        $contents = $dating->getContent($id);

        $photos = $dating->getPhoto($id,0);
        $photos_chat = $dating->getPhoto($id,1);
        $weekly_id = $id;
        $comment = $dating->getComment($id);
        $jiecao_coin = UserData::find()->select('jiecao_coin')->where(['user_id'=>Yii::$app->user->id])->asArray()->one();

        return $this->render('date-view',[

            'area'=>$area,
            'contents'=>$contents,
            'photos'=>$photos,
            'photos_chat'=>$photos_chat,
            'weekly_id'=>$weekly_id,
            'comments'=>$comment,
            'total'=>$jiecao_coin['jiecao_coin'],

        ]);

    }

    public function encryption($url){

        $session = Yii::$app->session;

        if(!$session->isActive)
            $session->open();

        if( empty($session->get('date_today_password')) ){
            return $this->redirect(['/site/encryption','url'=>$url]);
        }

    }
    /**
     * @param int $type
     * @return string
     * 优质男女心动后援
     */
    public function actionHighQualityGender($type=1){
        $this->layout = '/basic';
        $modelClass = new OtherTextPic();
        $data = $modelClass::find()->where(['type'=>$type])->orderBy('created_at desc')->asArray();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('high-quality-gender',[
            'model' => $model,
            'pages' => $pages,
        ]);
    }
    function getip(){
        if(!empty($_SERVER["HTTP_CLIENT_IP"])){
            $cip = $_SERVER["HTTP_CLIENT_IP"];
        }
        else if(!empty($_SERVER["HTTP_X_FORWARDED_FOR"])){
            $cip = $_SERVER["HTTP_X_FORWARDED_FOR"];
        }
        else if(!empty($_SERVER["REMOTE_ADDR"])){
            $cip = $_SERVER["REMOTE_ADDR"];
        }
        else{
            $cip = '';
        }
        preg_match("/[\d\.]{7,15}/", $cip, $cips);
        $cip = isset($cips[0]) ? $cips[0] : 'unknown';
        unset($cips);
        return $cip;
    }
    public function actionLocation(){

     /*   $ip=$this->getip();
        $url = "http://api.map.baidu.com/location/ip?ak=SGfb9Gzb8qoHu4Yk65RC6t5KNZmcYXCt&coor=bd09ll";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($ch);
        if(curl_errno($ch))
        { echo 'CURL ERROR Code: '.curl_errno($ch).', reason: '.curl_error($ch);}
        curl_close($ch);
        $info = json_decode($output, true);
        return var_dump($info);
        if($info['status'] == "0"){
            $lotx = $info['content']['point']['y'];
            $loty = $info['content']['point']['x'];
            $citytemp = $info['content']['address_detail']['city'];
            $keywords = explode("市",$citytemp);
            $city = $keywords[0];
        }
        else{
            $lotx = "34.2597";
            $loty = "108.9471";
            $city = "西安";
        }


        var_dump($lotx);//x坐标  纬度
        var_dump($loty);//y坐标  经度
        var_dump($city);//用户Ip所在城市*/
        return $this->render('location');

    }

    /**
     * @param $number
     * @param $url
     * @param $sum
     * @return string|\yii\web\Response
     * @throws ErrorException
     * 觅约报名
     */
    public function actionDatingSignupRewirte($number,$url,$sum){

        $user_id = Yii::$app->user->id;
        $user = new \backend\models\User();
        $user_number = $user->getNumber($user_id);
        if(empty($user_number)){
            return "您的网站编号未绑定请联系客服修改";
        }
        $user_wx = UserWeichat::findOne(['number'=>$user->getNumber($user_id)]);
        if(empty($user_wx)){
            return $this->redirect('/weixin/firefighters/index-test');
        }
        $model = new DatingSignup();
        $recharge_record = new RechargeRecord();

        $dating_signup_num = DatingSignup::find()->where(['like_id'=>$number,'status'=>0])->count();

        $query = Dating::find()->where(['number'=>$number])->asArray()->one();

        $extra = array('mark'=>$query['content'],'require'=>$query['url'],'introduction'=>$query['introduction'],'worth'=>$query['worth'],'avatar'=>$query['avatar'],'number'=>$query['number'],'address'=>$query['title']);

        $userData = UserData::find()->select('jiecao_coin')->where(['user_id'=>$user_id])->one();

        if($userData['jiecao_coin']<$query['worth']){

            return "节操币不足！";
        }

        if($dating_signup_num>9){

            return "报名已满！无法报名！！";
        }

        if($recharge_record::find()->where(['user_id'=>$user_id,'status'=>[9,10],'subject'=>3])->count()>4){
            return "已有大量报名正在审核中，请等待审核结束后再报名！".$user_id;
        }

        if(DatingSignup::findOne(["user_id"=>$user_id,"like_id"=>$number])!=null){

            return "已经报名！";
        }

        $model->type = 2;
        $model->like_id = $number;
        $model->worth = $query['worth'];
        $model->area = $query['title'];
        $model->avatar = $query['avatar'];

        if($model->save()){

            if($sum==9){

                Yii::$app->db->createCommand()->update('{{%weekly}}',['full_time'=>time()],['number'=>$number])->execute();
            }

            $recharge = new RechargeRecord();
            $recharge->number = $query['worth'];
            $recharge->order_number = '4'.time().rand(1000,9999);
            $recharge->type = "密约报名";
            $recharge->subject = 3;
            $recharge->extra = json_encode($extra);

            if($recharge->save()){

                Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin-$recharge->number where user_id=".$user_id)->execute();
                Yii::$app->session->setFlash('success','报名成功');
                try{
                    SaveToLog::userBgRecord("觅约报名{$number}，扣除节操币{$recharge->number}");
                }catch (Exception $e){
                    throw new ErrorException($e->getMessage());
                }

                return $this->redirect(urldecode($url));

            }else{

                throw new ErrorException;
            }

        }else{

            throw new ErrorException;
        }

    }

    /**
     * @return \yii\web\Response
     * 根据ip获取地理位置跳转
     */
    public function actionRed(){

        $address = new Address();
        $locs =  $address->getAddress();

        $loc = "'$locs'";

        if(!empty($loc)){

            $query = Yii::$app->db->createCommand("select title from {{%weekly}} where title=$loc")->queryOne();

            if(!empty($query)){

                $cid = $query['title'];

            }else{

                $cid = "北京";
            }

        }else{

            $cid = "北京";
        }

        return $this->redirect('date-past?title='.$cid.'&company='.AccessToken::antiBlocking());
    }

    /**
     * @return string
     * 联系我们
     */
    public function actionContact()
    {

        $this->layout = 'basic';
        $girl_rand = $boy_rand = 0;
        $model = Website::find()->with('photo')->asArray();
        $ips = isset($_SERVER["HTTP_X_REAL_IP"])?$_SERVER["HTTP_X_REAL_IP"]:$_SERVER["REMOTE_ADDR"];
        $boy = $model->where(['website_id'=>2])->one();
        $girl = $model->where(['website_id'=>3])->one();

        $limitIpModel = new ContactIpLimits();

        if(($ip = $limitIpModel::findOne(['ip'=>$ips]))!=null){

            $girl_rand = $ip->girl_rand;
            $boy_rand = $ip->boy_rand;

        }else{

            $girl_rand = mt_rand(0,count($girl['photo'])-1);
            $boy_rand = mt_rand(0,count($boy['photo'])-1);

            $limitIpModel->ip = $ips;
            $limitIpModel->girl_rand = $girl_rand;
            $limitIpModel->boy_rand = $boy_rand;
            $limitIpModel->save();

        }

        return $this->render('contact',['boy'=>$boy['photo'],'girl'=>$girl['photo'],'girl_rand'=>$girl_rand,'boy_rand'=>$boy_rand]);
    }
    public function actionTextIp(){
        $ip = Yii::$app->getRequest()->getUserIP();
        return var_dump($ip);

    }
    /**
     * @return string
     * 联系我们
     */
    public function actionContact2()
    {
        $this->layout = 'basic';
        $model = new Website();

        return $this->render('contact2',['boy'=>$model::findOne(5)->photo,'boy_phone'=>$model::findOne(4)->photo]);

    }

    /**
     * @return string
     * 关于我们
     */
    public function actionAbout()
    {
        $this->layout = 'basic';
        return $this->render('about');
    }

    /**
     * @return string
     * 登陆
     */
    public function actionLogin()
    {
        $this->layout = 'basic';

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {

            if(isset($_GET['where'])&&$_GET['where']=='forum'){

                return $this->redirect('/forum/default');
            }
//            if(in_array(Yii::$app->user->id,[10004,10024])){
  //              return $this->redirect('/collecting-files/send-collecting-url');
    //        }
            if(in_array(Yii::$app->user->id,[10010,10018])){
                return $this->redirect('/local/default/send-collection-url');
            }
            if(in_array(Yii::$app->user->id,[10009,10019])){
                return $this->redirect('/sm/default/send-collection-url');
            }

            if(in_array(Yii::$app->user->id,AuthAssignment::find()->select('user_id')->column())){
                return $this->redirect('/member/enter-background');
            }
            return $this->goBack();

        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }

    }

    /**
     * @return \yii\web\Response
     * 退出登陆
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * 手机注册
     */
    public function actionSignup()
    {
        $this->layout = 'basic';
        $getInvite = isset($_GET['invite'])?$_GET['invite']:'';
        $invite = SignupBefore::findOne(['invite_code'=>$getInvite,'status'=>1]);
        if(empty($getInvite)){
            throw new NotFoundHttpException('请求的页面不存在');
        }else{
            if(empty($invite)){
                throw new NotFoundHttpException('非法请求');
            }
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if($model->cellphone==''){
                return '手机号码不可为空';
            }
            if($model->smsCode==''){
                return '验证码不可为空';
            }
            if ($user = $model->signup()) {

                $array = ['username'=>$user->username,'password'=>$user->none];
                $this->setMes()->addUser($array);

                Yii::$app->db->createCommand()->insert('{{%user_profile}}', [
                    'user_id' => $user->id,
                    'number' => $invite->number,
                    'address_1'=>'{"province":"'.$invite->address.'","city":""}'
                ])->execute();
                Yii::$app->db->createCommand()->update('{{%user}}',['groupid'=>$invite->groupid],'id='.$user->id)->execute();
                Yii::$app->db->createCommand()->insert('{{%user_data}}', [
                    'user_id'=>$user->id,
                    'jiecao_coin'=>$invite->coin,
                ])->execute();

                $invite->status = 0;$invite->update();
                try{
                    if($invite->groupid==2){
                        $vip_text = "普通会员";
                    }elseif($invite->groupid==3){
                        $vip_text = "高端会员";
                    }elseif($invite->groupid==4){
                        $vip_text = "至尊会员";
                    }elseif($invite->groupid==5){
                        $vip_text = "私人定制";
                    }elseif($invite->groupid==1){
                        $vip_text = "网站会员";
                    }else{
                        $vip_text = "未知会员";
                    }
                    SaveToLog::userBgRecord("手机注册成功，{$vip_text}，拥有{$invite->coin}节操币,",$user->id);
                }catch (Exception $e){
                    throw new ErrorException($e->getMessage());
                }

                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect('date-today?url='.AccessToken::antiBlocking());
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     * 国外手机邮箱注册
     */
    public function actionEmailSignup(){

        $this->layout = 'basic';
        $getInvite = isset($_GET['invite'])?$_GET['invite']:'';
        $invite = SignupBefore::findOne(['invite_code'=>$getInvite,'status'=>1]);
        if(empty($getInvite)){
            throw new NotFoundHttpException('请求的页面不存在');
        }else{
            if(empty($invite)){
                throw new NotFoundHttpException('非法请求');
            }
        }

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {
            if($model->email==''){
                return '邮箱不可为空';
            }
            if ($user = $model->emailSignup()) {

                try{
                    if($invite->groupid==2){
                        $vip_text = "普通会员";
                    }elseif($invite->groupid==3){
                        $vip_text = "高端会员";
                    }elseif($invite->groupid==4){
                        $vip_text = "至尊会员";
                    }elseif($invite->groupid==5){
                        $vip_text = "私人定制";
                    }elseif($invite->groupid==1){
                        $vip_text = "网站会员";
                    }else{
                        $vip_text = "未知会员";
                    }
                    SaveToLog::userBgRecord("邮箱注册成功，{$vip_text}，拥有{$invite->coin}节操币,",$user->id);

                }catch (Exception $e){
                    throw new ErrorException($e->getMessage());
                }
                $array = ['username'=>$user->username,'password'=>$user->none];
                $this->setMes()->addUser($array);

                Yii::$app->db->createCommand()->insert('{{%user_profile}}', [
                    'user_id' => $user->id,
                    'number' => $invite->number,
                    'address_1'=>'{"province":"'.$invite->address.'","city":""}'
                ])->execute();

                Yii::$app->db->createCommand()->update('{{%user}}',['groupid'=>$invite->groupid],'id='.$user->id)->execute();

                Yii::$app->db->createCommand()->insert('{{%user_data}}', [
                    'user_id'=>$user->id,
                    'jiecao_coin'=>$invite->coin,
                ])->execute();

                $invite->status = 0;$invite->update();

                if (Yii::$app->getUser()->login($user)) {
                    return $this->redirect('date-today');
                }
            }
        }

        return $this->render('email-signup', [
            'model' => $model,
        ]);
    }

    /**
     * @return string
     * 短信发送注册验证码
     */
    public function actionSendLoginCode(){
        $mobile = Yii::$app->request->post('mobile');
        $type = Yii::$app->request->post('type');
        $ip = Yii::$app->getRequest()->getUserIP();
        $saveToForm = new SendMobileCode();
        $queryMobile = $saveToForm::find()->where(['mobile'=>$mobile,'created_at'=>strtotime('today')])->count();
        if($queryMobile>5){
            $data = json_encode(array('statusCode'=>130013,'statusMsg'=>'该手机今日所发短信数量超出平台上限'));
        }else{
            if($type=='reset'){
                /* @var $user User */
                $user = User::findOne([
                    'status' => User::STATUS_ACTIVE,
                    'cellphone' => $mobile,
                ]);
                if ($user) {
                    if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                        $user->generatePasswordResetToken();
                    }
                    if ($user->save()) {
                        $data = $this->sendCodeSaveSession($saveToForm,$mobile,$ip);
                    }else{
                        $data = json_encode(array('statusCode'=>130014,'statusMsg'=>'服务器内部错误请联系客服，或者改用邮箱验证'));
                    }
                }else{
                    $data = json_encode(array('statusCode'=>130015,'statusMsg'=>'该手机号码不存在'));
                }
            }else{
                $data = $this->sendCodeSaveSession($saveToForm,$mobile,$ip);
            }

        }
        echo $data;
    }

    /**
     * @param $saveToForm
     * @param $mobile
     * @param $ip
     * @return string
     * 短信验证没保存到session
     */
    public function sendCodeSaveSession($saveToForm,$mobile,$ip){

        $code = rand(100000,999999);
        $send = SendTemplateSMS::send($mobile,array($code,'10'),"133718");
        if($send->statusCode==0){
            $saveToForm->ip = $ip;
            $saveToForm->mobile = $mobile;
            $saveToForm->save();
            if(!Yii::$app->session->isActive){Yii::$app->session->open();}
            Yii::$app->session->set('login_sms_code',$code);
            Yii::$app->session->set('login_sms_mobile',$mobile);
            Yii::$app->session->set('login_sms_time',time());
            $data = json_encode(array('statusCode'=>0,'statusMsg'=>'短信发送成功，验证码10分钟内有效,请注意查看手机短信。如果未收到短信，请在60秒后重试！'));
        }else{
            $data = json_encode($send);
        }

        return $data;
    }

    /**
     * 检查验证手机是否存在
     */
    public function actionCheckMobileExists()
    {
        $mobile = Yii::$app->request->post('mobile');
        $type = Yii::$app->request->post('type');
        if(empty($mobile)){
            $data = json_encode(array('error_code'=>13001,'error_msg'=>'手机号不可为空'));
        }elseif($this->findMobile($mobile,$type)){
            $data = json_encode(array('error_code'=>0000,'error_msg'=>'手机号码合法'));
        }else{
            if($type=='signup'){
                $data = json_encode(array('error_code'=>13003,'error_msg'=>'该手机号码已注册'));
            }else{
                $data = json_encode(array('error_code'=>13004,'error_msg'=>'该手机号码未注册'));
            }
        }
        echo $data;
    }

    /**
     * @param $mobile
     * @param $type
     * @return bool
     * 查询数据库中手机号码
     */
    public function findMobile($mobile,$type){
        if($type=='signup'){
            return empty(User::findByMobile($mobile));
        }else{
            return !empty(User::findByMobile($mobile));
        }
    }

    /**
     * @return Easemob
     * 注册同时注册环信配置信息
     */
    protected function setMes(){

        $options = array(
            'client_id'  => Yii::$app->params['client_id'],   //你的信息
            'client_secret' => Yii::$app->params['client_secret'],//你的信息
            'org_name' => Yii::$app->params['org_name'],//你的信息
            'app_name' => Yii::$app->params['app_name'] ,//你的信息
        );
        $e = new Easemob($options);

        return $e;
    }

    /**
     * @return string
     * 重置密码
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                try{
                    SaveToLog::userBgRecord("邮箱找回密码");
                }catch (Exception $e){
                    throw new ErrorException($e->getMessage());
                }
                Yii::$app->getSession()->setFlash('success', '检查您的电子邮件，以进一步说明。');
            } else {
                Yii::$app->getSession()->setFlash('error', '对不起，我们无法重置密码的电子邮件提供。');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * @return string|\yii\web\Response
     * 重置密码请求
     */
    public function actionMobilePasswordReset(){

        $model = new PasswordResetMobileForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = User::findOne(['cellphone'=>$model->cellphone]);
            Yii::$app->getSession()->setFlash('success', '我们发送短信验证的号码。');
            try{
                SaveToLog::userBgRecord("手机验证找回密码");
            }catch (Exception $e){
                throw new ErrorException($e->getMessage());
            }
            return $this->redirect(['reset-password','token'=>$user->password_reset_token]);
        }

        return $this->render('mobilePasswordResetToken', [
            'model' => $model,
        ]);

    }

    /**
     * @param $token
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     * 重置密码成功后的跳转
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            try{
                SaveToLog::userBgRecord("找回密码成功");
            }catch (Exception $e){
                throw new ErrorException($e->getMessage());
            }
            Yii::$app->getSession()->setFlash('success','新密码已经保存。');
            return $this->redirect(['/site/login']);
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    /**
     * @param string $url
     * @return string|\yii\web\Response
     * 进入密约需要密码
     */
    public function actionEncryption($url = '/date-today'){

        $session = Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        $cookie = Yii::$app->response->cookies;
        $cookie->remove('gd_zz_sy');

        $model = new Encryption();

        if(!empty($session->get('date_today_password'))){
            return $this->redirect($url);
        }elseif($model->load(Yii::$app->request->post())&&$model->sign()){
            $session->set('date_today_password',$model->password);
            return $this->redirect($url);
        }
        return $this->render('encryption',['model'=>$model,]);
    }


}
