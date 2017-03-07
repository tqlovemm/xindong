<?php
namespace api\modules\v5\controllers;

use Pingpp\Charge;
use Pingpp\Pingpp;
use Pingpp\Util\Util;
use Yii;
use yii\db\Query;
use yii\myhelper\Response;
use yii\rest\ActiveController;

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/2
 * Time: 17:31
 */

class OrderController extends ActiveController
{
    public $modelClass = 'api\modules\v5\models\Order';
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

    //心动会员接口
    public function actionIndex()
    {

        $result = Yii::$app->db->createCommand('SELECT * FROM pre_member_sorts WHERE flag = 1  ')->queryAll();
        $result2 = Yii::$app->db->createCommand('SELECT money,giveaway FROM pre_predefined_jiecao_coin WHERE type = 2 and member_type >2 ')->queryAll();
        if(!$result){
            $str = array(
                'code'  =>  '201',
                'msg'   =>  '查询失败',
                'data'  =>  '',
            );
            return $str;
        }
        foreach($result as $list){
            $list['permissions'] = explode('@',$list['permissions']);
            $data['key'] = array();
            $data['value'] = array();
            foreach ($list['permissions']  as $key=>$item){

                array_push($data['key'],explode('：',$item)[0]);
                array_push($data['value'],explode('：',$item)[1]);
            }
            $list['momber_id'] = $list['id'];
            unset($list['id']);
            $list['permissions']= $data;
            $ll[] = $list;

        }
        $str = array(
            'code'  =>  '200',
            'msg'   =>  '查询成功',
            'data'  =>  $ll,
            'data2' =>  $result2,
        );
        return $str;
    }

    //添加支付凭据,监听支付
    public function actionCreate()
    {

        $ping_key_path = Yii::getAlias('@config') . '/ping_public_key.pem';
        $pub_key_path = Yii::getAlias('@config') . '/rsa_private_key.pem';
        Pingpp::setApiKey(Yii::$app->params['api-key']);
        Pingpp::setPrivateKeyPath($pub_key_path);
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $model->number = $model->number*100;

        //webhooks
        $headers = Util::getRequestHeaders();
        $signature = isset($headers['X-Pingplusplus-Signature']) ? $headers['X-Pingplusplus-Signature'] : NULL;

        //未支付成功
        if(!$signature){
            $ch = Charge::create(
                array(
                    'order_no' => $model->order_number,   //商品数量
                    'app' => array('id' => Yii::$app->params['id']),
                    'channel' => $model->channel,   //支付途径
                    'amount' => $model->number,    //订单总额
                    'client_ip' => '127.0.0.1',    //发起请求客户端IP
                    'currency' => 'cny',  //货币代码
                    'subject' => $model->type, //商品标题
                    'body' => $model->subject, //商品描述
                    'extra' => array(

                    ),   //特定渠道发起交易时需要的额外参数以及部分渠道支付成功返回的额外参数
                    'description'=>$model->user_id,     //用户id
                    'metadata' =>  array(
                        'sorts_id'  =>  $model->sorts_id,
                    ),   //会员类型id
                )
            );
            if(!$ch){
                $str = array(
                    'code'  =>  201,
                    'msg'   =>  '支付凭证生成失败',
                    'data'  =>  '',
                );
            }else{


                $str = array(
                    'code'  =>  200,
                    'msg'   =>  '支付凭证生成成功',
                    'data'  =>  $ch,
                );
            }
            return $str;
        }

        //验证webhooks签名
        $data = file_get_contents('php://input');
        $result = $this->verify_signature($data, $signature, $ping_key_path);

        if ($result === 1) {

            // 验证通过
        } elseif ($result === 0) {
            http_response_code(400);
            echo 'verification failed';
            exit;
        } else {
            http_response_code(400);
            echo 'verification error';
            exit;
        }

        //charge.succeeded
        $event = json_decode($data, true);
        if ($event['type'] == 'charge.succeeded') {
            $charge = $event['data']['object'];
            //支付宝生成的订单号
            $model->alipay_order = $charge['id'];
            $model->order_number = $charge['order_no'];
            $model->number = $charge['amount']/100;
            $price = (new Query())->from('pre_predefined_jiecao_coin')->where(['money'=>$model->number])->one();
            if(!$price){

                Response::show('201','操作失败','没有这个充值价格');
            }
            $model->subject = (int)$charge['body'];
            $model->channel = $charge['channel'];
            $model->type = $charge['subject'];
            //$model->extra = $charge['extra'];
            $model->user_id = $charge['description'];

            //支付成功
            $model->platform = 1;
            $model->status = 10;

            if (!$model->save()) {
                $str = array(
                    'code' => '201',
                    'msg' => '插入数据库失败',
                    'data' => array_values($model->getFirstErrors())[0],
                );
                return $str;
            }

            if($model->subject == 1 ){
                //充值节操币
                $total = (int)($model->number);
                Yii::$app->db->createCommand("update pre_user_data set jiecao_coin = jiecao_coin+{$total} where user_id={$model->user_id}")->execute();
            }elseif($model->subject == 3){
                //觅约报名
                //$model->subject = 3;
                //$model->type="觅约报名";
            }elseif($model->subject ==2 ){
                //会员升级
                $sorts_id = $charge['metadata']['sorts_id'];
                //判断是否是是高端升级为至尊
                $old_group = (new Query())->from('pre_user')->where(['id'=>$model->user_id])->one();
                $member_sorts = (new Query())->from('pre_member_sorts')->where(['id'=>$sorts_id])->one();
                if($old_group['groupid'] == 3){
                    $high = (new Query())->from('pre_member_sorts')->where(['id'=>5])->one();
                    $low = (new Query())->from('pre_member_sorts')->where(['id'=>4])->one();
                    $dec = $high['price_1']-$low['price_1'];
                    if($model->number != $dec){
                        Response::show('201','操作失败','没有该价格');
                    }
                    $total = $high['giveaway']-$low['giveaway'];
                }else{
                    $total = $member_sorts['giveaway'];
                    $price = (new Query())->from('pre_predefined_jiecao_coin')->where(['giveaway'=>$total])->one();
                    if(!$price){
                        Response::show('201','操作失败','没有这个赠送价格');
                    }
                }

                Yii::$app->db->createCommand("update pre_user set groupid = {$member_sorts['groupid']} where id={$model->user_id}")->execute();
                Yii::$app->db->createCommand("update pre_user_data set jiecao_coin = jiecao_coin+{$total} where user_id={$model->user_id}")->execute();
                Yii::$app->db->createCommand("update pre_recharge_record set giveaway = giveaway+{$total} where user_id={$model->user_id}")->execute();
            }

            $created = strtotime('today');
            //本周末时间戳
            $week = strtotime('next sunday');
            //当月第一天
            $mouth = mktime(23,59,59,date('m'),date('t'),date('Y'))+1;

            Yii::$app->db->createCommand("update pre_recharge_record set created_at = {$created},week_time={$week},mouth_time={$mouth} where id={$model->id}")->execute();

            http_response_code(200); // PHP 5.4 or greater
        } elseif ($event['type'] == 'refund.succeeded') {
            http_response_code(200); // PHP 5.4 or greater
        } else {

            http_response_code(200);

            if (!isset($event->type)) {
                header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                exit("fail");
            }
            switch ($event->type) {
                case "charge.succeeded":
                    // 开发者在此处加入对支付异步通知的处理代码
                    header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                    break;
                case "refund.succeeded":
                    // 开发者在此处加入对退款异步通知的处理代码
                    header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
                    break;
                default:
                    header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                    break;
            }
        }
    }


    protected function verify_signature($raw_data, $signature, $pub_key_path) {
        $pub_key_contents = file_get_contents($pub_key_path);
        // php 5.4.8 以上，第四个参数可用常量 OPENSSL_ALGO_SHA256
        return openssl_verify($raw_data, base64_decode($signature), $pub_key_contents, 'sha256');
    }

}