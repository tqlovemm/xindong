<?php


namespace frontend\controllers;

use backend\models\JiecaoCoinOperation;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use backend\modules\setting\models\AppPush;

class AppPushController extends Controller
{

    const HOUR = 3600;
    protected function config(){

        Yii::setAlias('@apppush','@backend/apppush');
        $path = Yii::getAlias('@apppush');
        require_once ($path.'/demo.php');
        //http的域名
        define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

        //https的域名
        //define('HOST','https://api.getui.com/apiex.htm');


        define('APPKEY','8grrIU5kcr8b4d7KHJTUN5');
        define('APPID','o2fItBGkhp9vFjQIkI8Q55');
        define('MASTERSECRET','AKptZQVIC48I933wBYGQh1');

        // define('DEVICETOKEN','');
        // define('Alias','请输入别名');
        //define('BEGINTIME','2015-03-06 13:18:00');
        //define('ENDTIME','2015-03-06 13:24:00');


    }

    public function actionIndex(){

        if(!isset($_GET['app_name'])&&$_GET['app_name']!=='shisanpingtai'){

            return;
        }
        self::updateData();//冻结节操币部分到期自动扣除
        $this->config();

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

    protected function updateData(){

        $query = new JiecaoCoinOperation();

        $model = $query->find()->where(['type'=>0,'status'=>10])->asArray()->all();

        foreach($model as $item){

            if(time()-$item['created_at']>self::HOUR*$item['expire']){

                Yii::$app->db->createCommand("update {{%user_data}} set frozen_jiecao_coin=frozen_jiecao_coin-$item[value] where user_id=$item[user_id]")->execute();
                Yii::$app->db->createCommand("update {{%jiecao_coin_operation}} set status=0 where id=$item[id]")->execute();

            }
        }
    }

    public function actionCleartable(){

        Yii::$app->db->createCommand("truncate table {{%cctv}}")->execute();

    }


    public function actionServer(){
        $this->layout = false;

        return $this->render('server');

    }



}