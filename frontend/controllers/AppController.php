<?php
namespace frontend\controllers;

use backend\modules\app\models\AppOrderList;
use common\components\PushConfig;
use common\components\Vip;
use frontend\modules\weixin\models\VoteSignInfo;
use yii\myhelper\AccessToken;
use yii\web\Controller;

class AppController extends Controller
{
    public function actionIndex($id){
        $model = AppOrderList::findOne(['order_number'=>$id]);
        return $this->render('index',['model'=>$model]);
    }

    public function actionPush(){

        $title = '十三平台';
        $msg = 'ccc';
        PushConfig::config();
        $data = array('push_title'=>$title,'push_content'=>$msg,'push_post_id'=>"62",'push_type'=>'SSCOMM_NEWSCOMMENT_DETAIL');
        $extras = json_encode($data);
        $res = pushMessageToList(1, $title, $msg, $extras ,['2380569401cb7db1834eb482793a0321','852353a969268de35489f4712681f77a']);
        return var_dump($res);
    }

    public function actionThread(){
        Vip::sort();
    }

    public function actionT(){

        VoteSignInfo::updateAllCounters(['vote_count'=>-1],['id'=>20]);
    }

    public function actionC(){
        $data['out_trade_no'] = 20170602;
        $attach_access['oid'] = "tqlovemmforever";
        $attach_access['total_fee'] = 20;
        $payoAccach = ['out_trade_no'=>$data['out_trade_no'],'openid'=>$attach_access['oid'],'total_fee'=>$attach_access['total_fee']];
        $url = "http://51payo.tecclub.cn/weixin/one-day-pa/record";
        return var_dump((new AccessToken())->postData($url,$payoAccach));
    }
}