<?php

namespace frontend\modules\member\controllers;
use app\components\SaveToLog;
use app\components\WxpayComponents;
use app\models\CreditValue;
use backend\modules\bgadmin\models\BgadminMember;
use backend\modules\recharge\models\AutoJoinPrice;
use backend\modules\setting\models\PredefinedJiecaoCoin;
use backend\modules\setting\models\SystemMsg;
use frontend\models\CollectingFilesText;
use frontend\models\DatingSignup;
use frontend\models\UserProfile;
use frontend\modules\member\models\DatingCuicu;
use frontend\modules\member\models\DatingEvaluate;
use frontend\modules\member\models\DatingVip;
use frontend\modules\weixin\models\FirefightersSignUp;
use Yii;
use frontend\models\RechargeRecord;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\Pagination;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use common\models\User;

class UserController extends Controller
{
    public $layout = '@app/themes/basic/layouts/main';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index','member-ship-info','jiecao-coin','jiecao-recharge','jiecao-recharge-wxpay',
                    'recharge-record','purchase-history','member-upgrade','member-setting','dating-record','dating-records','more','system-msg-delete','frozen-coin','auto-join-pay',
                    'cookie',
                ],
                'rules' => [
                    [
                        'actions' => ['index','member-ship-info','jiecao-coin','jiecao-recharge','jiecao-recharge-wxpay',
                            'recharge-record','purchase-history','member-upgrade','member-setting','dating-record','dating-records','more','system-msg-delete','frozen-coin'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['auto-join-pay','cookie'
                        ],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                ],
            ],

        ];
    }
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }



   public function actionIndex(){
       $user_id = Yii::$app->user->id;
        $query = new CreditValue();
        $model = (new Query())->from("{{%user}}")->select('username,nickname,avatar,sex,groupid')->where(['id'=>$user_id])->one();
        $userData = (new Query())->from("{{%user_data}}")->select('jiecao_coin')->where(['user_id'=>$user_id])->one();

        $credit = $query::find()->select('levels,viscosity,lan_skills,sex_skills,appearance')->where(['user_id'=>$user_id])->asArray()->one();

        if(empty($credit)){
           $query->user_id = $user_id;
           $query->save();

           $credit = $query::find()->select('levels,viscosity,lan_skills,sex_skills,appearance')->where(['user_id'=>$user_id])->asArray()->one();
        }


       switch($model['groupid']){
            case 0:$member_type = "管理员";break;
            case 1:$member_type = "网站会员";break;
            case 2:$member_type = "普通会员";break;
            case 3:$member_type = "高端会员";break;
            case 4:$member_type = "至尊会员";break;
            case 5:$member_type = "私人定制";break;
        }

        $system_msg = (new Query())->from("{{%system_msg}}")->select('read_user')->where(['status'=>1])->all();

        $system_msg_num = 0;

        foreach ($system_msg as $item) {

           $read_user = explode(',',$item['read_user']);

           if(!in_array($user_id,$read_user)){

               $system_msg_num = ++$system_msg_num;
           }
        }

        $jiecao_msg_num = (new Query())->from("{{%system_msg}}")->where(['read'=>1,'user_id'=>$user_id])->andWhere(['in','status',[4,5]])->count();
        $firefighter_num = (new Query())->from("{{%firefighters_sign_up}}")->where(['read'=>1,'user_id'=>$user_id,'status'=>[0,1,2]])->count();
        $dating_num = (new Query())->from("{{%system_msg}}")->where(['read'=>1,'user_id'=>$user_id,'status'=>2])->count();
        $num = array('system'=>$system_msg_num+$jiecao_msg_num,'dating'=>$dating_num,'credit'=>array_sum($credit),'firefighter'=>$firefighter_num);

        return $this->render('index',[
            'model'=>$model,
            'member_type'=>$member_type,
            'userData'=>$userData,
            'num'=>$num
        ]);

   }

    public function actionMemberShipInfo(){

        $model = (new Query())->from("{{%user}}")->select('username,nickname,avatar,sex')->where(['id'=>Yii::$app->user->id])->one();
        $profile = (new Query())->from("{{%user_profile}}")->select('*')->where(['user_id'=>Yii::$app->user->id])->one();

        $model['sex']=1?'女':'男';
        return $this->render('member-ship-info',['model'=>$model,'profile'=>$profile]);
    }

    public function actionJiecaoCoin(){

        $groupid = Yii::$app->user->identity->groupid;
        $userData = (new Query())->from("{{%user_data}}")->select('jiecao_coin,frozen_jiecao_coin')->where(['user_id'=>Yii::$app->user->id])->one();
        $predefined = (new Query())->from("{{%predefined_jiecao_coin}}")->where(['type'=>0,'status'=>10,'member_type'=>[0,$groupid]])->orderBy('money desc')->all();
        return $this->render('jiecao-coin',['userData'=>$userData,'predefined'=>$predefined]);

    }
    public function actionJiecaoRecharge(){

        $id = Yii::$app->request->get('id');
        $user_id = Yii::$app->user->id;
        $userInfo = Yii::$app->db->createCommand("select * from {{%user}} as u left join {{%user_profile}} as p on p.user_id=u.id where id=$user_id")->queryOne();
        $model = new RechargeRecord();

        if($id!=null){

            $predefinedInfo = Yii::$app->db->createCommand("select * from {{%predefined_jiecao_coin}} where id=$id")->queryOne();
            $price =  $predefinedInfo['money'];
            $number = '2'.time().rand(10000,99999);
            $name = '节操币充值';

            $body = $predefinedInfo['giveaway'].','.$user_id;

            new \shiyang\alipaywap\Alipay($number,$name,$price,'',$body);

        }else{


            throw new ForbiddenHttpException;

        }

        return $this->render('jiecao-recharge',['model'=>$model,'userInfo'=>$userInfo]);

    }

    public function actionCoinRechargeAlipay($id){

        $user_id = Yii::$app->user->id;
        $groupid = Yii::$app->user->identity->groupid;
        $get_number = \backend\models\User::getNumber($user_id);
        $user_number = empty($get_number)?'':$get_number;
        if($id!=null){
            $predefinedInfo = PredefinedJiecaoCoin::findOne($id);
            $price =  $predefinedInfo->money;
            if($user_id==10001){
                $price=0.01;
            }
            $number = '2'.time().rand(10000,99999);
            $name = '节操币充值';
            $body = array('giveaway'=>$predefinedInfo->giveaway, 'user_id'=>$user_id, 'user_number'=>$user_number,'groupid'=>$groupid, 'type'=>1,'description'=>"获节操币{$price}，赠送{$predefinedInfo->giveaway}节操币");
            new \shiyang\alipaywap\Alipay($number,$name,$price,'http://13loveme.com/contact',json_encode($body));
        }
    }

    public function actionCookie(){

        $cache = Yii::$app->cache;
        var_dump($cache);
    }
    public function actionAutoJoinPay(){

        $get = Yii::$app->request->get();

        $data = explode(',',$get['data']);
        $sort = $data[0];
        $area = $data[1];
        $recharge = $data[2];
        $type = $data[3];

        $autoJoinPrice = AutoJoinPrice::findOne(['member_sort'=>$sort,'member_area'=>$area,'recharge_type'=>$recharge]);
        $order_number = '5'.time().rand(10000,99999);

        if($type=='alipay'){

            if(empty($autoJoinPrice)){

                throw new ForbiddenHttpException('非法访问');
            }

            new \shiyang\alipaywap\Alipay($order_number,'入会十三交友',$autoJoinPrice->price,'',$get['data']);

        }elseif($type=='weipay'){

            if(empty($autoJoinPrice)){
                throw new ForbiddenHttpException('非法访问');
            }

            $attach = array();
            $attach['flag']=$data['5'];
            $attach['sort']=$data['0'];
            $attach['area']=$data['1'];
            $attach['recharge']=$data['2'];
            $attach['cellphone']=$data['4'];
            $attach['user_id']=0;
            $attach['groupid']=0;

            SaveToLog::log($attach);
            $wxpay = new WxpayComponents();
            $wxpay->Wxpay("自动入会",$order_number,$autoJoinPrice->price*100,json_encode($attach),'autoJoining');

        }else{

            throw new ForbiddenHttpException('非法访问');
        }
    }
    public function actionJiecaoRechargeWxpay(){

        $id = Yii::$app->request->get('id');

        if($id!=null){

            $predefinedInfo = Yii::$app->db->createCommand("select * from {{%predefined_jiecao_coin}} where id=$id")->queryOne();
            $price =  $predefinedInfo['money'];
            $giveaway = $predefinedInfo['giveaway'];
            $number = '2'.time().rand(10000,99999);
            $name = '节操币充值';

            $attach = array('user_id'=>\Yii::$app->user->id,'type'=>1,'groupid'=>$giveaway);
            $wxpay = new WxpayComponents();
            $wxpay->Wxpay($name,$number,$price*100,json_encode($attach),'jiecaocoin');

        }else{

            throw new ForbiddenHttpException;
        }


    }
    public function actionRedDating(){

        $cookie = Yii::$app->response->cookies;
        $cookie->remove('gd_zz_sy');
        return $this->redirect("/date-today");
    }

    public function actionPayType($id){


        return $this->render('pay-type',['id'=>$id]);
    }


    public function actionPurchaseHistory(){

        $user_id=Yii::$app->user->id;
        $model = RechargeRecord::find()->where(['user_id'=>$user_id])->andWhere(['in','subject',[2]])->orderBy('created_at desc')->asArray()->all();

        return $this->render('purchase-history',['model'=>$model]);

    }



    public function actionMemberSetting(){


        return $this->render('member-setting');

    }

    public function actionCredit(){
        $model = new CreditValue();
        $credit = $model::find()->select("levels,viscosity,lan_skills,sex_skills,appearance")->where(['user_id'=>Yii::$app->user->id])->asArray()->one();

        if(empty($credit)){

            $model->user_id = Yii::$app->user->id;
            $model->save();
            $credit = $model::find()->select("levels,viscosity,lan_skills,sex_skills,appearance")->where(['user_id'=>Yii::$app->user->id])->asArray()->one();
        }
        $creditAll = array_sum($credit);
        return $this->render('credit',['credit'=>$creditAll]);
    }

    public function actionCreditIntro(){

        $credit = CreditValue::find()->where(['user_id'=>Yii::$app->user->id])->asArray()->one();

        return $this->render('credit-intro',['credit'=>$credit]);

    }

    public function actionSystemMsg(){

        $user_id = Yii::$app->user->id;
        $query = new Query;
        $query->from('{{%system_msg}}')
            ->where(['status'=>[4,5]])->andWhere(['user_id'=>$user_id])->orWhere(['status'=>1])->orderBy('created_at desc');
        $photos = Yii::$app->tools->Pagination($query);

        $system_msg = (new Query())->from("{{%system_msg}}")->select('id,read_user')->where(['status'=>1])->all();

        foreach ($system_msg as $item) {

            $read_user = explode(',',$item['read_user']);

            if(!in_array(Yii::$app->user->id,$read_user)){

                Yii::$app->db->createCommand("update {{%system_msg}} set read_user = CONCAT(read_user,'$user_id,') where status=1 and id=$item[id]")->execute();//系统消息
            }
        }

        Yii::$app->db->createCommand()->update("{{%system_msg}}",['read'=>0],"user_id=$user_id")->execute();//个人消息

        return $this->render("system-msg",[

            'model'=>$photos['result'],
            'pages' => $photos['pages']

        ]);

    }

    public function actionServiceJoin(){
        $user_id = Yii::$app->user->id;
        $model = new DatingVip();
        $query = $model::find()->where(['user_id'=>$user_id])->orderBy("created_at desc")->asArray()->one();
        return $this->render("service-join",['query'=>$query]);
    }

    public function actionDatingVip(){

        $user_id = Yii::$app->user->id;
        $vip = Yii::$app->user->identity->groupid;
        if($vip>2){
            $model = new DatingVip();
            if(!$this->isServiceJoin($user_id)){
                $model->user_id = $user_id;
                $model->created_at = time();
                $coin = ($vip==3)?99:198;
                $model->coin = $coin;
                $own_coin = Yii::$app->db->createCommand("select jiecao_coin from pre_user_data  where user_id={$user_id}")->queryOne();
                if($own_coin['jiecao_coin']>=$coin){
                    $execute = Yii::$app->db->createCommand("update pre_user_data set jiecao_coin = jiecao_coin-{$coin} where user_id={$user_id}")->execute();

                    if($execute){
                        $model->save();
                        \common\components\SaveToLog::userBgRecord("开通客服介入功能，扣除{$coin}节操币",$user_id);
                    }
                }else{
                    return $this->render('already-records-evaluate',['result'=>"对不起，您的节操币不足"]);
                }
            }
            return $this->redirect("service-join");
        }else{
            return $this->render('already-records-evaluate',['result'=>"等级不足无法开通"]);
        }

    }
    public function actionUserFile(){

        $user_id = Yii::$app->user->id;
        $vip = Yii::$app->user->identity->groupid;
        if($vip<2){
            return $this->render('already-records-evaluate',['result'=>"您的等级不足，请升级为普通及以上会员"]);

        }
        $number = \backend\models\User::getNumber($user_id);
        if($number==null){
            return $this->render('already-records-evaluate',['result'=>"您还没有绑定平台编号，请联系客服绑定"]);
        }
        $model = CollectingFilesText::findOne($number);
        if(!empty($model)){
            return $this->redirect("/files/$model->flag");
        }else{

            $addressT = array('新疆','澳门','香港','广西','宁夏','内蒙古','西藏');

            $userProfile = UserProfile::findOne($user_id);
            $address_1 = json_decode($userProfile->address_1,true)['province'];

            if((strstr($address_1,"市")!=false)||(strstr($address_1,"省")!=false)){
                $address_1 = substr($address_1,0,strlen($address_1)-3);
            }

            foreach ($addressT as $add){

                if(strstr($address_1,$add)!=false){
                    $address_1 = $add;
                }
            }

            $query = (new Query())->select('flop_id,area')->from('pre_flop_content')->where(['not in','area',['精选汉子','优质','女生档案']])->all();
            $area = ArrayHelper::map($query,'flop_id','area');

            $collectModel = new CollectingFilesText();
            $collectModel->id = $number;
            $collectModel->address = $address_1;
            $collectModel->flop_id = isset(array_keys($area,$address_1)[0])?array_keys($area,$address_1)[0]:0;
            $collectModel->flag = md5(time().md5(rand(10000,99999)));

            if($collectModel->save()){

                return $this->redirect("/files/$collectModel->flag");

            }else{

                var_dump($collectModel->errors);

            }

        }

    }

    public function actionSystemMsgDelete($id){

        $model = SystemMsg::findOne($id);
        $model->delete();
        echo $id;
    }

    public function actionDatingRecordDetail($id){

        $model = RechargeRecord::findOne($id);
        if(empty($model)){
            return $this->redirect("dating-record");
        }

        return $this->render('dating-record-detail',['model'=>$model]);
    }

    public function actionDatingRecordsDetail($id){

        $model = RechargeRecord::findOne($id);
        $cc = $dd = 0;
        if(empty($model)){
            return $this->redirect("dating-record");
        }

        if(in_array($model->status,[11])){

            $user_id = Yii::$app->user->id;
            $ccModel = new DatingCuicu();

            if($ccModel::findOne(['user_id'=>$user_id,'ccid'=>$id,'type'=>1])!=null){
                $cc = 1;
            }

            if($ccModel::findOne(['user_id'=>$user_id,'ccid'=>$id,'type'=>2])!=null){
                $dd=1;
            }
        }

        return $this->render('dating-records-detail',['model'=>$model,'cc'=>$cc,'dd'=>$dd]);

    }
    protected function isServiceJoin($user_id){
        $model = new DatingVip();
        $query = $model::find()->where(['user_id'=>$user_id])->orderBy("created_at desc")->asArray()->one();
        $mouth_second = strtotime("+1 months",$query['created_at']);
        $expire_second = $mouth_second-time();
        if(empty($query) or ($expire_second<0)){
            return false;
        }
        return true;
    }
    public function actionDatingRecordsCuicu($id){

        $user_id = Yii::$app->user->id;
        if(!$this->isServiceJoin($user_id)){
            echo 1;exit();
        }
        $model = RechargeRecord::findOne($id);
        if(!empty($model)&&in_array($model->status,[9,10])){
            $time = 43200-(time()-$model->updated_at);
            if($time>0){
                echo json_encode("等待倒计时结束后催促开放");
            }else{
                $ccModel = new DatingCuicu();
                if($ccModel::findOne(['user_id'=>$user_id,'ccid'=>$id,'type'=>0])==null){
                    $ccModel->ccid = $id;
                    if($ccModel->save()){
                        echo json_encode("ok");
                    }else{
                        echo json_encode($ccModel->errors);
                    }
                }else{
                    echo json_encode("您已经催促过了，客服正在加速处理中，请耐心等待。");
                }
            }
        }else{

            echo json_encode("催促不合法");
        }

    }
    public function actionDatingRecordsMakefriend($id){

        $user_id = Yii::$app->user->id;
        $ccModel = new DatingCuicu();
        if($ccModel::findOne(['user_id'=>$user_id,'ccid'=>$id,'type'=>1])==null){
            $ccModel->ccid = $id;
            $ccModel->type = 1;
            if($ccModel->save()){
                echo json_encode("ok");
            }else{
                echo json_encode($ccModel->errors);
            }
        }else{
            echo json_encode("您已经确认添加对方为好友");
        }

    }
    public function actionDatingRecordsServicejoin($id){

        $user_id = Yii::$app->user->id;
        if(!$this->isServiceJoin($user_id)){
            echo 1;exit();
        }
        $ccModel = new DatingCuicu();
        if($ccModel::findOne(['user_id'=>$user_id,'ccid'=>$id,'type'=>2])==null){
            $ccModel->ccid = $id;
            $ccModel->type = 2;
            if($ccModel->save()){
                echo json_encode("ok");
            }else{
                echo json_encode($ccModel->errors);
            }
        }else{
            echo json_encode("您已经要求客服介入，请耐心等待");
        }
    }
    public function actionDatingRecordsEvaluate($id){


        $user_id = Yii::$app->user->id;
        $model = new DatingEvaluate();

        if($model::findOne(['user_id'=>$user_id,'ccid'=>$id])==null){

            $model->ccid = $id;
            $model->user_id = $user_id;
            $model->created_at = time();

            if ($model->load(Yii::$app->request->post())) {
                $model->evaluate = $_POST['evaluate'];
                if ($model->validate()) {
                    if($model->save()){
                        return $this->redirect("dating-records-detail?id=$id");
                    }
                }
            }

            return $this->render('dating-records-evaluate', [

                'model' => $model,

            ]);

        }

        return $this->render('already-records-evaluate',['result'=>"您已经做出评价"]);

    }

    public function actionDatingRecordDelete($id){

        $model = RechargeRecord::findOne($id);

        if($model->status!==10){

            $model->status=15;
            $model->update();
        }

        return $this->redirect("dating-record");
    }

    public function actionDatingSignupRecord(){

        $user_id = Yii::$app->user->id;
        $firefighter_num = (new Query())->from("{{%firefighters_sign_up}}")->where(['read'=>1,'user_id'=>$user_id,'status'=>[0,1,2]])->count();
        $dating_num = (new Query())->from("{{%system_msg}}")->where(['read'=>1,'user_id'=>$user_id,'status'=>2])->count();
        return $this->render('dating-signup-record',['date_num'=>$dating_num,'fire_num'=>$firefighter_num]);

    }

    public function actionFirefighterRecord(){
        $user_id=Yii::$app->user->id;
        $data = FirefightersSignUp::find()->where(['user_id'=>$user_id])->andWhere(['status' => [0,1,2]])->with('sign')->orderBy(' created_at desc ');
        $photos = Yii::$app->tools->Pagination($data);
        Yii::$app->db->createCommand()->update("{{%firefighters_sign_up}}",['read'=>0],"user_id=$user_id")->execute();
        return $this->render('firefighter-record',[
           'model' => $photos['result'],
           'pages' => $photos['pages'],
        ]);

    }

    public function actionFirefighterDetail($id){

        $sign_id = FirefightersSignUp::find()->where(['id'=>$id])->andWhere(['status' => [0,1,2]])->with("sign")->one();

        if(empty($sign_id)){
            return $this->redirect("firefighter-record");
        }

        return  $this->render('firefighter-detail',['model'=>$sign_id['sign'],'id'=>$sign_id['id'],'fire_status'=>$sign_id['status'],'reason'=>$sign_id['reason']]);
    }

    public function actionFirefighterDelete($id){

        $model = FirefightersSignUp::findOne($id);
        $model->status = 3;
        $model->update();
        return $this->redirect('firefighter-record');
    }

    public function actionDatingRecord(){

        $user_id=Yii::$app->user->id;
        $query = new Query;
        $query->from('{{%recharge_record}}')
            ->where(['user_id'=>$user_id])->andWhere(['in','subject',[3]])->andWhere(['in','status',[8,9,10,11,12,13]])->orderBy('created_at desc');
        $photos = Yii::$app->tools->Pagination($query);
        Yii::$app->db->createCommand()->update("{{%system_msg}}",['read'=>0],"user_id=$user_id")->execute();
        return $this->render('dating-record',[
            'model' => $photos['result'],
            'pages' => $photos['pages']
        ]);

        /*   $user_id=Yii::$app->user->id;

           $model = RechargeRecord::find()->where(['user_id'=>$user_id])->andWhere(['in','subject',[3]])->orderBy('id desc')->asArray()->all();
           return $this->render('dating-record',['model'=>$model]);*/

    }

    public function actionDatingRecords(){

        $user_id=Yii::$app->user->id;
        $query = new Query;
        $query->from('{{%recharge_record}}')
            ->where(['user_id'=>$user_id])->andWhere(['in','subject',[3]])->andWhere(['in','status',[8,9,10,11,12,13]])->orderBy('created_at desc');
        $photos = Yii::$app->tools->Pagination($query);
        Yii::$app->db->createCommand()->update("{{%system_msg}}",['read'=>0],"user_id=$user_id")->execute();
        return $this->render('dating-records',[
            'model' => $photos['result'],
            'pages' => $photos['pages']
        ]);

        /*   $user_id=Yii::$app->user->id;

           $model = RechargeRecord::find()->where(['user_id'=>$user_id])->andWhere(['in','subject',[3]])->orderBy('id desc')->asArray()->all();
           return $this->render('dating-record',['model'=>$model]);*/

    }

    public function actionRechargeRecord(){

        $user_id=Yii::$app->user->id;
        $query = new Query;
        $query->from('{{%recharge_record}}')
            ->where(['user_id'=>$user_id])->andWhere(['in','subject',[1,3,4,5]])->orderBy('created_at desc');
        $photos = Yii::$app->tools->Pagination($query);

        return $this->render('recharge-record',[
            'photos' => $photos['result'],
            'pages' => $photos['pages']
        ]);


    /*  $user_id=Yii::$app->user->id;

        $model = RechargeRecord::find()->where(['user_id'=>$user_id])->andWhere(['in','subject',[1,3,4,5]])->orderBy('id desc')->asArray()->all();

        return $this->render('recharge-record',['model'=>$model]);*/

    }

    public function actionMore($type,$id){

        if($type==0){
            $limit = array(3);
        }elseif($type==1){
            $limit = array(1,3,4);
        }else{
            $limit = array();
        }

        $user_id=Yii::$app->user->id;

        $model = RechargeRecord::find()->where(['user_id'=>$user_id])->andWhere(['in','subject',$limit])->andWhere(['<','id',$id])->orderBy('id desc')->asArray()->one();

        $query = json_decode($model['extra'],true);

        $query['id'] = $model['id'];
        $query['created_at'] = $model['created_at'];
        $query['subject'] = $model['subject'];
        $query['status'] = $model['status'];
        $query['value'] = $model['number'];
        $query['giveaway'] = $model['giveaway'];
        $query['refund'] = $model['refund'];

        echo json_encode($query);

    }

    public function actionFrozenCoin(){

        $frozen_coin_info = (new Query())->select('user_id,value,reason,where,created_at,number_info')->from("{{%jiecao_coin_operation}}")->where(['user_id'=>Yii::$app->user->id,'status'=>10])->all();

        return $this->render('frozen-coin',['frozen_coin'=>$frozen_coin_info]);
        
    }
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在。');
        }
    }

}