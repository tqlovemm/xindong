<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/7/14
 * Time: 15:55
 */

namespace api\modules\v4\controllers;

use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\rest\ActiveController;
use yii\myhelper\Response;
use yii\web\ForbiddenHttpException;

class AppRechargeVerifyController extends ActiveController
{

    public $modelClass = 'api\modules\v4\models\AppRechargeVerify';

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

    public function actionIndex()
    {

        $modelClass = $this->modelClass;

        $query = $modelClass::find()->select('title as area')->where(['status'=>2])->groupBy('title')->asArray()->all();


        return $query;


    }

    public function actionCreate(){

        $model = new $this->modelClass;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');

        if($model->level==0){
            $total = (int)$model->number+(int)$model->giveaway;
            $model->subject = 1;
            $model->type="节操币充值";
            Yii::$app->db->createCommand("update pre_user_data set jiecao_coin = jiecao_coin+{$total} where user_id={$model->user_id}")->execute();

        }elseif($model->level>1&&$model->level<5){

            $member_price = (new Query())->select('price_1')->from('pre_member_sorts')->where(['flag'=>1])->all();
            $price = ArrayHelper::map($member_price,'price_1','price_1');
            if(!in_array($model->number,$price)){

                throw new ForbiddenHttpException('非法操作');

            }else{

                $model->subject = 2;
                $model->type="会员升级";
                Yii::$app->db->createCommand("update pre_user set groupid = {$model->level} where id={$model->user_id}")->execute();
            }


        }else{
            Response::show(2501,'失败','level参数错误');
        }


        return $model;
    }

    public function actionCreate2()
    {  
        $model = new $this->modelClass;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        
        $apple_receipt = $model->apple_receipt; //苹果内购的验证收据,由客户端传过来
        $jsonData = array('receipt-data'=>$apple_receipt);//这里本来是需要base64加密的，我这里没有加密的原因是客户端返回服务器端之前，已经作加密处理
        $jsonData = json_encode($jsonData);
        $url = 'https://buy.itunes.apple.com/verifyReceipt';  //正式验证地址
        //$url = 'https://sandbox.itunes.apple.com/verifyReceipt'; //测试验证地址
        $response = $this->http_post_data($url,$jsonData);

        if($response->{'status'} == 0){

            if($model->level==0){
                $total = (int)$model->number+(int)$model->giveaway;
                $model->subject = 1;
                $model->type="节操币充值";
                Yii::$app->db->createCommand("update pre_user_data set jiecao_coin = jiecao_coin+{$total} where user_id={$model->user_id}")->execute();

            }elseif($model->level>1&&$model->level<5){

                $member_price = (new Query())->select('price_1')->from('pre_member_sorts')->where(['flag'=>1])->all();
                $price = ArrayHelper::map($member_price,'price_1','price_1');
                if(!in_array($model->number,$price)){

                   throw new ForbiddenHttpException('非法操作');

                }else{

                    $model->subject = 2;
                    $model->type="会员升级";
                    Yii::$app->db->createCommand("update pre_user set groupid = {$model->level} where id={$model->user_id}")->execute();
                }


            }else{
                Response::show(2501,'失败','level参数错误');
            }
            
            if (!$model->save()) {
                return array_values($model->getFirstErrors())[0];
            }
            $query = Yii::$app->db->createCommand("select u.groupid,d.jiecao_coin from pre_user as u left join pre_user_data as d on d.user_id=u.id where u.id={$model->user_id}")->queryOne();
            Response::show(202,'成功',$query);

        }else{

            Response::show($response->{'status'},'验证失败');
        }


    }
    /**
     * 随着苹果系统越来越强大，有种马上要开始胡来的节奏，个人认为强制添加内购就是其中之一，虽然很多人都特别鄙视这种行为，然并卵。
     * 具体的官方给出的验证规则，大家可以详细阅读看看：http://zengwu3915.blog.163.com/blog/static/2783489720137605156966/?suggestedreading
     * apple官方提供的文档地址：https://developer.apple.com/library/prerelease/ios/releasenotes/General/ValidateAppStoreReceipt/Chapters/ValidateRemotely.html
     **/

    //curl请求苹果app_store验证地址
    function http_post_data($url, $data_string) {
        $curl_handle=curl_init();
        curl_setopt($curl_handle,CURLOPT_URL, $url);
        curl_setopt($curl_handle,CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl_handle,CURLOPT_HEADER, 0);
        curl_setopt($curl_handle,CURLOPT_POST, true);
        curl_setopt($curl_handle,CURLOPT_POSTFIELDS, $data_string);
        curl_setopt($curl_handle,CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl_handle,CURLOPT_SSL_VERIFYPEER, 0);
        $response_json =curl_exec($curl_handle);
        $response =json_decode($response_json);
        curl_close($curl_handle);
        return $response;
    }


}