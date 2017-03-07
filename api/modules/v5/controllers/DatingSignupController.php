<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/9
 * Time: 13:41
 */

namespace api\modules\v5\controllers;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\helpers\Response;

class DatingSignupController extends ActiveController
{

    public $modelClass = 'api\modules\v5\models\DatingSignup';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionCreate(){

        Response::show('205','操作失败','app此功能尚未开放，可前往我们官网觅约 http://www.13loveme.com');
        /*$model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        $area_china = array(
            '美国','英国','荷兰','加拿大','比利时','澳洲','德国','法国','新西兰','马来西亚','西班牙','意大利','泰国','韩国','新加坡'
        );
        $user_id = $model->user_id;
        $like_id = $model->like_id;
        $address = array();
        $need_coin = (new Query())->from('{{%weekly}}')->where(['number'=>$like_id])->one();
        //用户信息
        $userInfo = Yii::$app->db->createCommand("select u.groupid,p.address_1,p.address_2,p.address_3 from {{%user}} as u left join {{%user_profile}} as p on p.user_id=u.id where u.id=$model->user_id")->queryOne();

        if(!empty($userInfo['address_1'])){
            $address_1 = array_values(json_decode($userInfo['address_1'],true));
            $address = $address_1;
        }


        if(!empty($userInfo['address_2'])){
            $address_2 = array_values(json_decode($userInfo['address_2'],true));
            $address = array_merge($address,$address_2);
        }
        if(!empty($userInfo['address_3'])){
            $address_3 = array_values(json_decode($userInfo['address_3'],true));
            $address = array_merge($address,$address_3);
        }
        $girl_area = array($need_coin['title'],$need_coin['title2'],$need_coin['title3']);
        //是否报名成功
        $ex = (new Query())->from('{{%dating_signup}}')->where(['user_id'=>$user_id,'like_id'=>$like_id])->one();
        if(!empty($ex)){
            Response::show('201','保存失败','已经报名');
        }

        //是否是会员
        $is_member = (new Query())->select('*')->from('pre_user')->where(['id'=>$user_id])->one();
        $arr = array(3,4);
        if(!in_array($is_member['groupid'],$arr)){
            Response::show('202','保存失败','请先升级成高端或者至尊会员');
        }

        //节操币是否够觅约

        $model->area = $need_coin['title'];
        $model->worth = $need_coin['worth'];
        $model->avatar = $need_coin['avatar'];
        $has_coin = (new Query())->from('{{%user_data}}')->where(['user_id'=>$user_id])->one();
        if($has_coin['jiecao_coin']-$need_coin['worth']<0){
            Response::show('203','保存失败','心动币不足，请充值');
        }

        //是否名额已满
        $full = (new Query())->from('{{%dating_signup}}')->where(['like_id'=>$model->like_id])->count();
        if($full>=10){
            Response::show('204','保存失败','名额已满');
        }

        //觅约对象是否存在
        $true = (new Query())->from('{{%weekly}}')->where(['number'=>$like_id])->one();
        if(empty($true)){
            Response::show('205','保存失败','觅约对象不存在');
        }

       //判断觅约时间是否过期
        $expire = ($need_coin['updated_at']+$need_coin['expire'])<time();

        $gong = array_intersect($area_china,$girl_area,$address);
        if($expire && $userInfo['groupid'] == 3 && empty($gong)){
            Response::show('206','保存失败',"等级不足，您只能觅约$need_coin[expire]小时内的妹子");
        }*/


       /* $address = array();
        if(!empty($userInfo['address_1'])){
            $address_1 = array_values(json_decode($userInfo['address_1'],true));
            $address = $address_1;
        }
        if(!empty($userInfo['address_2'])){
            $address_2 = array_values(json_decode($userInfo['address_2'],true));
            $address = $address_2;
        }
        if(!empty($userInfo['address_3'])){
            $address_3 = array_values(json_decode($userInfo['address_3'],true));
            $address = $address_3;
        }*/

        /*$need_coin['title2'] = $need_coin['title2'] ?$need_coin['title2'] :$need_coin['title'];
        $need_coin['title3'] = $need_coin['title3'] ?$need_coin['title3'] :$need_coin['title'];
        //判断地址
        if(!$this->check($address,$need_coin['title'])&&!$this->check($address,$need_coin['title2'])&&!$this->check($address,$need_coin['title3'])&&$userInfo['groupid'] == 3){

            Response::show('207','保存失败','等级不足，您当前等级只能报名本地区觅约');
        }

        //保存数据
        if(!$model->save()){
            return array_values($model->getFirstErrors()[0]);
        }else{
            $extra = array('mark'=>$need_coin['content'],'require'=>$need_coin['url'],'introduction'=>$need_coin['introduction'],'worth'=>$need_coin['worth'],'avatar'=>$need_coin['avatar'],'number'=>$need_coin['number'],'address'=>$need_coin['title']);
            $order_number = '4'.time().rand(1000,9999);
            Yii::$app->db->createCommand()->insert('{{%recharge_record}}',[
                'user_id'=>$model->user_id,
                'number'=>$need_coin['worth'],
                'created_at'=>strtotime('today'),
                'updated_at'=>time(),
                'subject'=>3,
                'status'=>10,
                'platform'=>2,
                'type'=>'密约报名',
                'order_number'=>$order_number,
                'extra'=>json_encode($extra),

            ])->execute();
            Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin-$need_coin[worth] where user_id=$model->user_id")->execute();
            Response::show('200','保存成功','报名成功');
        }*/


    }

    function check($add,$area){
        foreach($add as $list){
            if(strpos($list,$area)!==false){

                return true;
            }
        }
        return false;
    }

    public function finedModel($id){

        $modelclass = $this->modelClass;
        if($model = $modelclass::findOne($id) !== null){
            return $model;
        }else{
            Throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}