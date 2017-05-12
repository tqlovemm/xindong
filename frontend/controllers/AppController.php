<?php
namespace frontend\controllers;

use backend\modules\app\models\AppOrderList;
use common\components\PushConfig;
use yii\web\Controller;

class AppController extends Controller
{
    public function actionIndex($id){
        $model = AppOrderList::findOne($id);
        return $this->render('index',['model'=>$model]);
    }

    public function actionPush(){

        $title = 'faw';
        $msg = 'ccc';
        PushConfig::config();
        $data = array('push_title'=>$title,'push_content'=>$msg,'push_post_id'=>"127",'push_type'=>'SSCOMM_NEWSCOMMENT_DETAIL');
        $extras = json_encode($data);
        pushMessageToList(1, $title, $msg, $extras ,['2380569401cb7db1834eb482793a0321']);
    }
}