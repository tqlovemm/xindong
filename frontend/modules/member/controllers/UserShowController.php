<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/4/29
 * Time: 14:39
 */

namespace frontend\modules\member\controllers;

use app\components\WxpayComponents;
use backend\modules\setting\models\MemberSorts;
use frontend\models\UserProfile;
use frontend\modules\member\Member;
use frontend\modules\member\models\UserVipTempAdjust;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\helpers\Html;
use yii\web\UploadedFile;
use Yii;
use yii\db\Query;
use \shiyang\alipaywap\Alipay;
use \backend\models\User;
class UserShowController extends Controller
{
    public $layout = '@app/themes/basic/layouts/main';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['update-member-info','index','member-show','single-member-details','upgrade-price','pay-type','member-upgrade-alipay','member-upgrade-wxpay'],

                'rules' => [
                    [
                        'actions' => ['update-member-info','index','member-show','single-member-details','upgrade-price','pay-type','member-upgrade-alipay','member-upgrade-wxpay'],
                        'allow' => true,
                        'roles' => ['@'],
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

        $group_id = Yii::$app->user->identity->groupid;
        $permissions = (new Query)->select("permissions")->from("{{%member_sorts}}")->where(['groupid'=>$group_id])->one();
        $permissions = explode('@',$permissions['permissions']);
        switch($group_id){

            case 0:$level = "网站管理员";break;
            case 1:$level = "网站会员";break;
            case 2:$level = "普通会员";break;
            case 3:$level = "高端会员";break;
            case 4:$level = "至尊会员";break;
            default :$level="私人定制";


        }
        return $this->render('index',['level'=>$level,'permissions'=>$permissions,'num'=>count($permissions)]);


    }

    public function actionUpdateMemberInfo($id=null){

        if($id==null){

            $id = \Yii::$app->user->id;
        }
        $model = $this->findModel($id);

        if($model->load(\Yii::$app->request->post())){

            $model->file = UploadedFile::getInstance($model, 'file');

            $model->file = $model->upload();

            if($model->country==0){

                $model->address = $model->getAddress($model->country).' '.$model->getAddress($model->province).' '.$model->getAddress($model->city).' '.$model->getAddress($model->area);

            }else{
                $model->address = $model->getAddress($model->country);
            }

            if($model->save()){

                return $this->redirect('index');

            }

        }
        return $this->render('_info_form',['model'=>$model]);

    }

    public function actionSite($pid, $typeid = 0)
    {
        $model = new UserProfile();

        $model = $model->getCityList($pid);

        if($typeid == 0){$aa="--请选择省--";}elseif($typeid == 1 && $model){$aa="--请选择市--";}else if($typeid == 2 && $model){$aa="--请选择区--";}

        echo Html::tag('option',$aa, ['value'=>'']) ;

        foreach($model as $value=>$name)
        {
            echo Html::tag('option',Html::encode($name),array('value'=>$value));
        }
    }

    /*展示所有会员信息*/
    public function actionMemberShow(){

        $query = (new Query)->select('groupid,count(groupid) as sum')->from('{{%user}}')->groupBy('groupid')->all();

        $model = MemberSorts::find()->where(['flag'=>0])->with('cover')->orderBy("is_recommend desc")->asArray()->all();

        return $this->render('member-show',['model'=>$model,'query'=>$query]);

    }

    public function actionSingleMemberDetails($id){

        $model = $this->getPrice($id);
        $need_price = $this->getUpgradePrice($id)-$this->getUpgradePrice();

        switch($model['groupid']){

            case 0:
            case 1:$img = Yii::getAlias('@web')."/images/member/putong.png";break;
            case 2:$img = Yii::getAlias('@web')."/images/member/putong.png";break;
            case 3:$img = Yii::getAlias('@web')."/images/member/gaoduan.png";break;
            case 4:$img = Yii::getAlias('@web')."/images/member/zhizun.png";break;
            default :$img=Yii::getAlias('@web')."/images/member/siren.png";
        }
        switch(Yii::$app->user->identity->groupid){

            case 0:
            case 1:$level = '网站会员';break;
            case 2:$level = '普通会员';break;
            case 3:$level = '高端会员';break;
            case 4:$level = '至尊会员';break;
            default :$level = '私人订制';
        }

        $permissions = explode('@',$model['permissions']);
        $num = count($permissions);

        return $this->render('single-member-details',['model'=>$model,'need_price'=>$need_price,'img'=>$img,'level'=>$level,'num'=>$num,'permissions'=>$permissions]);

    }

    public function actionUpdateDetails($id,$uid=null){

        $model_member = MemberSorts::find()->where(['flag'=>0])->andWhere("id!=$id")->with('cover')->orderBy("is_recommend desc")->asArray()->all();
        $query = MemberSorts::findOne($id);

        $query_app = MemberSorts::findOne(['member_name'=>$query->member_name,'flag'=>1]);
        $model = $this->getPrice($id,$uid);
        $need_price = $this->getUpgradePrice($id,$uid)-$this->getUpgradePrice(null,$uid);

        if(!empty($uid)){
            $userModel = User::findOne($uid);
            $group_id = $userModel->groupid;
        }else{
            $group_id = !Yii::$app->user->isGuest?Yii::$app->user->identity->groupid:1;
        }

        switch($group_id){
            case 0:
            case 1:$level = '网站会员';break;
            case 2:$level = '普通会员';break;
            case 3:$level = '高端会员';break;
            case 4:$level = '至尊会员';break;
            default :$level = '私人订制';
        }

        return $this->render('update-details',['model'=>$model,'update_id'=>$query_app->id,'model_member'=>$model_member,'group_id'=>$group_id,'need_price'=>$need_price,'level'=>$level,'query'=>$query]);

    }

    protected function getPrice($id,$uid=null){

        $model = MemberSorts::find()->where('id=:id',[':id'=>$id])->asArray()->one();

        $sort_1 = array('北京市','上海市','广州市','深圳市','浙江省','江苏省');
        $sort_2 = array('新疆维吾尔自治区','内蒙古自治区','青海省','甘肃省','西藏自治区','宁夏回族自治区','海南省');

        $user_id = !Yii::$app->user->isGuest?Yii::$app->user->id:$uid;$addresses = array();
        $address = Yii::$app->db->createCommand("select address_1,address_2,address_3 from {{%user_profile}} where user_id=$user_id")->queryOne();

        if(!empty($address['address_1'])){

            $address_1 = array_values(json_decode($address['address_1'],true));

            if($address_1[0]=='广东省'){

                if(!empty($address_1[1])){

                    if(in_array($address_1[1],array('广州市','深圳市'))){

                        $address_1[0] = $address_1[1];
                    }

                } else{

                    $address_1[0] = '广州市';
                }
            }

            array_push($addresses,$address_1[0]);

        }
        if(!empty($address['address_2'])){

            $address_2 = array_values(json_decode($address['address_2'],true));

            if($address_2[0]=='广东省'){

                if(!empty($address_2[1])){

                    if(in_array($address_2[1],array('广州市','深圳市'))){

                        $address_2[0] = $address_2[1];
                    }

                } else{

                    $address_2[0] = '广州市';
                }
            }

            array_push($addresses,$address_2[0]);

        }
        if(!empty($address['address_3'])){

            $address_3 = array_values(json_decode($address['address_3'],true));

            if($address_3[0]=='广东省'){

                if(!empty($address_3[1])){

                    if(in_array($address_3[1],array('广州市','深圳市'))){

                        $address_3[0] = $address_3[1];
                    }

                } else{

                    $address_3[0] = '广州市';
                }
            }

            array_push($addresses,$address_3[0]);

        }

        if(array_intersect($sort_1,$addresses)){

            $price = $model['price_1'];
        }else{

            $flag=true;

            foreach($addresses as $v){

                if(!in_array($v,$sort_2)){
                    $flag=false;
                    break;
                }
            }

            if($flag){

                $price = $model['price_2'];

            }else{
                $price = $model['price_3'];

            }

        }

        $model['price'] = $price;
        $model['address'] = isset(json_decode($address['address_1'])->province)?json_decode($address['address_1'])->province:'';

        return $model;

    }

    public function getUpgradePrice($id=null,$uid=null){

        if($id==null){
            if(!empty($uid)){
                $userModel = User::findOne($uid);
                $group_id = $userModel->groupid;
            }else{
                $group_id = !Yii::$app->user->isGuest?Yii::$app->user->identity->groupid:1;
            }
            $model = MemberSorts::find()->where('groupid=:groupid',[':groupid'=>$group_id])->asArray()->one();
        }else{
            $next_groupid = MemberSorts::find()->select('groupid')->where('id=:id',[':id'=>$id])->asArray()->one();
            $model = MemberSorts::find()->where('groupid=:groupid',[':groupid'=>$next_groupid['groupid']])->asArray()->one();
        }

        $sort_1 = array('北京市','上海市','广州市','深圳市','浙江省','江苏省');
        $sort_2 = array('新疆维吾尔自治区','内蒙古自治区','青海省','甘肃省','西藏自治区','宁夏回族自治区','海南省');

        $user_id = !Yii::$app->user->isGuest?Yii::$app->user->id:$uid;$addresses = array();
        $address = Yii::$app->db->createCommand("select address_1,address_2,address_3 from {{%user_profile}} where user_id=$user_id")->queryOne();

        if(!empty($address['address_1'])){

            $address_1 = array_values(json_decode($address['address_1'],true));

            if($address_1[0]=='广东省'){

                if(!empty($address_1[1])){

                    if(in_array($address_1[1],array('广州市','深圳市'))){

                        $address_1[0] = $address_1[1];
                    }

                } else{

                    $address_1[0] = '广州市';
                }
            }

            array_push($addresses,$address_1[0]);

        }
        if(!empty($address['address_2'])){

            $address_2 = array_values(json_decode($address['address_2'],true));

            if($address_2[0]=='广东省'){

                if(!empty($address_2[1])){

                    if(in_array($address_2[1],array('广州市','深圳市'))){

                        $address_2[0] = $address_2[1];
                    }

                } else{

                    $address_2[0] = '广州市';
                }
            }

            array_push($addresses,$address_2[0]);

        }
        if(!empty($address['address_3'])){

            $address_3 = array_values(json_decode($address['address_3'],true));

            if($address_3[0]=='广东省'){

                if(!empty($address_3[1])){

                    if(in_array($address_3[1],array('广州市','深圳市'))){

                        $address_3[0] = $address_3[1];
                    }

                } else{

                    $address_3[0] = '广州市';
                }
            }

            array_push($addresses,$address_3[0]);

        }

        if(array_intersect($sort_1,$addresses)){

            $price = $model['price_1'];

        }else{

            $flag=true;

            foreach($addresses as $v){

                if(!in_array($v,$sort_2)){
                    $flag=false;
                    break;
                }
            }

            if($flag){

                $price = $model['price_2'];

            }else{
                $price = $model['price_3'];

            }

        }

        return $price;
    }

    public function actionPayType($id){

        $user_id = Yii::$app->user->id;
        $sort = MemberSorts::findOne($id);
        $vipAdjust = new UserVipTempAdjust();
        if(!empty($model = $vipAdjust::findOne(['user_id'=>$user_id]))){
            if($sort->flag == 2){
                return "对不起您已经参与过试用";
            }
        }
        return $this->render('pay-type',['id'=>$id]);
    }

    public function actionAlipayMemberUpgrade($id){

        $user_id = Yii::$app->user->id;
        $model = $this->getPrice($id);
        if($model['flag']==2){
            $price = $model['price_1'];
        }else{
            $price = $this->getUpgradePrice($id)-$this->getUpgradePrice();
        }
        if($user_id==10001){
            $price = 0.01;
        }
        $vip = $model['groupid'];
        if($vip==2){
            $vip_txt = '普通会员';
        }elseif($vip==3){
            $vip_txt = '高端会员';
        }elseif($vip==4){
            $vip_txt = '至尊会员';
        }elseif($vip==5){
            $vip_txt = '私人订制';
        }else{
            $vip_txt = '网站会员';
        }

        $get_number = User::getNumber($user_id);
        $user_number = empty($get_number)?'':$get_number;
        $order_number = '3'.time().rand(10000,99999);

        if($model['flag']==2){
            $body = array('giveaway'=>$model['giveaway'],'groupid'=>$vip, 'user_id'=>$user_id, 'user_number'=>$user_number, 'type'=>3,'description'=>"升级为{$vip_txt}，赠送".($price/2)."节操币");
        }else{
            $body = array('giveaway'=>$model['giveaway'],'groupid'=>$vip, 'user_id'=>$user_id, 'user_number'=>$user_number, 'type'=>2,'description'=>"升级为{$vip_txt}，赠送".($price/2)."节操币");
        }

        new Alipay($order_number,$model['member_name'],$price*$model['discount'],'',json_encode($body));


    }
    public function actionMemberUpgradeWxpay($id){

        $model = $this->getPrice($id);
        if($model['flag']==2){
            $price = $model['price_1'];
        }else{
            $price = $this->getUpgradePrice($id)-$this->getUpgradePrice();
        }
        if(\Yii::$app->user->id==10001){
            $price = 0.01;
        }
        echo json_encode($price);
        $order_number = '3'.time().rand(10000,99999);

        if($model['flag']==2){
            $attach = array('user_id'=>\Yii::$app->user->id,'type'=>3,'groupid'=>$model['groupid']);
        }else{
            $attach = array('user_id'=>\Yii::$app->user->id,'type'=>2,'groupid'=>$model['groupid']);
        }

        $wxpay = new WxpayComponents();
        $wxpay->Wxpay("会员升级",$order_number,$price*$model['discount']*100,json_encode($attach),'memberup');

    }


    protected function findModel($id)
    {
        if (($model = UserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在。');
        }
    }

}