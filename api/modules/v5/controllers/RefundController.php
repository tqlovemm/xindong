<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/11
 * Time: 16:02
 */

namespace api\modules\v5\controllers;
use Yii;
use Yii\db\Query;
use yii\rest\ActiveController;
use yii\web\Response;
use yii\web\NotFoundHttpException;

class RefundController extends  ActiveController
{

    public  $modelClass = 'api\modules\v5\models\Refund';
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


    public function actionCreate()
    {
        $private_key_path = Yii::getAlias('@config') . '/rsa_private_key.pem';
        \Pingpp\Pingpp::setApiKey(Yii::$app->params['api-key']);
        \Pingpp\Pingpp::setPrivateKeyPath($private_key_path);
        $model = new $this->modelClass();

        //监听webhooks
        $raw_data = file_get_contents('php://input');
        $headers = \Pingpp\Util\Util::getRequestHeaders();
        $signature = isset($headers['X-Pingplusplus-Signature'])?$headers['X-Pingplusplus-Signature']:null;
        //退款凭证
        if(!$signature){
            $ch_id = $_POST['ch_id'];
            $ch = \Pingpp\Charge::retrieve($ch_id);
            $model->load(Yii::$app->getRequest()->getBodyParams(),'');
            $re = $ch->refunds->create(
                array(
                    'amount'    =>  $model->amount,
                    'metadata'  =>  array(
                        'user_id'   =>  $_POST['user_id'],
                        'title'     =>  $_POST['title'],
                    ),
                    'description'   => $_POST['title'],

                )
            );
            return $re;
        }

        //ping++公钥
        $ping_key_path = Yii::getAlias('@config').'/ping_public_key.pem';
        $result = verify_signature($raw_data,$signature,$ping_key_path);
        if($result === 1){

        }elseif($result === 0){
            http_response_code(400);
            echo 'verification failed';
            exit;
        }else{
            http_response_code(400);
            echo 'verification error';
            exit;
        }

        $event = json_decode($raw_data,true);
        if($event['type'] == 'charge.succeeded'){

        }elseif($event['type'] == 'refund.succeeded'){
            $refund = $event['data']['object'];
            $model->re_id = $refund['id'];
            $model->order_no = $refund['order_no'];
            $model->amount = (int)$refund['amount'];
            $model->user_id = $refund['metadata']['user_id'];
            $model->title = $refund['metadata']['title'];
            if(!$model->save){
                $str = array(
                    'code'  =>  '201',
                    'msg'   =>  '操作失败',
                    'data'  =>  ''

                );
                return $str;
            }

            //减少节操币
            Yii::$app->db->createCommand('update pre_user_data set jiecao_coin = jiecao_coin-{$model->amount} where user_id = {$model->user_id}')->execute();
            http_response_code(200);
        }else{
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


}