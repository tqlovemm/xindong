<?php
namespace frontend\controllers;

use common\components\SaveToLog;
use frontend\modules\weixin\models\AppWechatPush;
use Yii;
use yii\myhelper\AccessToken;
use yii\web\Controller;
use common\components\PushConfig;
use backend\modules\setting\models\AppPush;

class AppPushController extends Controller
{
    const HOUR = 3600;
    public function actionIndex(){

        if(!isset($_GET['app_name'])&&$_GET['app_name']!=='shisanpingtai'){
            return;
        }

        self::rechargePush();

        PushConfig::config();
        $query = new AppPush();
        $model = $query->find()->where('status!=0')->asArray()->one();
        $models = $query->find()->select('count(*) as count')->where('status=0')->andWhere(['is_read'=>1,'cid'=>$model['cid']])->asArray()->all();
        $count = (integer)$models[0]['count']+1;
        if(empty($model)){
            return;
        }

        $title=$model['title'];
        $msg=$model['msg'];
        $extras = urldecode($model['extras']);

        $cids = array_unique(array_filter(explode(',',$model['cid'])));

        define('CID',$model['cid']);

        if($model['status']==1){
            pushMessageToApp(1, $msg , $extras , $title);
            Yii::$app->db->createCommand("update {{%app_push}} set status=0 where id = $model[id]")->execute();
        }elseif($model['status']==2){
            pushMessageToList($count, $msg , $extras , $title , $cids);
            Yii::$app->db->createCommand("update {{%app_push}} set status=0 where id = $model[id]")->execute();
        }else{
            return;
        }

       // pushMessageToSingle('十三平台', 1, $msg , $extras , $title);

        // pushMessageToList();

        //getUserStatus();

        //pushMessageToApp();

        //stoptask();

        //setTag();

        //getUserTags();

        //pushMessageToSingleBatch();

        //getPersonaTagsDemo();

        //getUserCountByTagsDemo();

        //pushAPN();

        //pushAPNL();

        //getPushMessageResultDemo();

    }

    protected function rechargePush(){
        $model = AppWechatPush::findOne(['status'=>1]);
        if(!empty($model)){
            $model->status = 0;
            if(!$model->update()){
                SaveToLog::log($model->errors,'w_push.log');
            }else{
                $result = $this->temp("olQJss1mkh6-2xNlHwPKKh1IEFLQ",$model->user_id,$model->recharge_id,$model->wechat);
                if($result['errmsg']!="ok"){
                    $model->extra = json_encode($result);
                    $model->status = 1;
                    $model->update();
                }
            }
        }
    }

    protected function temp($openid,$user_id,$recharge_id,$wechat){

        $url = "http://13loveme.com/forum/admin-check?id=$recharge_id";
        $data = array(
            "touser"=>$openid,
            "template_id"=>"sj6-k6LNiMH1n86EuDcy0BA5QJGfqaNThVtVN-i8W_w",
            "url"=>$url,
            "topcolor"=>"#FF0000",
            "data"=>array(
                "first"=> array(
                    "value"=>"",
                    "color"=>"#000"
                ),
                "keyword1"=>array(
                    "value"=>"会员ID：{$user_id}",
                    "color"=>"#000"
                ),
                "keyword2"=> array(
                    "value"=>"会员微信号：{$wechat}",
                    "color"=>"#000"
                ),
                "keyword3"=> array(
                    "value"=>date('Y-m-d H:i:s',time()),
                    "color"=>"#000"
                ),
                "remark"=>array(
                    "value"=>"感谢您的参与！",
                    "color"=>"#000"
                )
            )
        );
        $msg = json_decode($this->sendTemp($data), true);

        return $msg;
    }

    /**
     * @param $data
     * @return mixed|string
     * 发送模板消息
     */
    public function sendTemp($data){

        $access = new AccessToken();
        $access_token = $access->getAccessToken();

        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;

        return $access->postData($url,json_encode($data));

    }
    public function actionServer(){
        $this->layout = false;
        return $this->render('server');
    }


}