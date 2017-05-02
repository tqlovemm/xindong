<?php
namespace frontend\modules\bgadmin\controllers;
use app\components\SendTemplateSMS;
use backend\models\UserLoginCode;
use common\models\User;
use common\Qiniu\QiniuUploader;
use frontend\models\CollectingSeventeenFilesText;
use yii\myhelper\WaterMark;
use yii\web\Controller;
class VerificationController extends Controller
{
    public function actionIndex()
    {
        return $this->render("index");
    }


    public function actionSaveSession(){

        $session = \Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        $code = mt_rand(1000,9999);

        $mobile = \Yii::$app->request->post('mobile');

        $session->set('code',$code);

        $session->set('mobile',$mobile);

        $send = SendTemplateSMS::send($mobile,array($code,'10'),"155776");

        echo json_encode($send);

    }
    public function actionSaveSe(){

        $codeModel = new UserLoginCode();
        $code = mt_rand(1000,9999);

        $mobile = \Yii::$app->request->get('mobile');

        if (strpos($mobile, '@')) {
            $param = 'email';
        } elseif(is_numeric($mobile)) {
            $param = 'cellphone';
        }else{
            $param = 'username';
        }
        $model = User::findOne([$param => $mobile, 'status' => 10]);

        $send = SendTemplateSMS::send($model->cellphone,array($code,'10'),"133718");
        if($send){
            $codeModel->mobile = $mobile;
            $codeModel->code = $code;
            $codeModel->save();
        }
        echo $_GET['callbackparams']."(".json_encode($send).")";

    }

    public function actionJudgeTrue(){

        $session = \Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        $send_code = \Yii::$app->request->post('code');
        $send_mobile = \Yii::$app->request->post('mobile');

        $save_code = $session->get('code');
        $save_mobile = $session->get('mobile');

        $result = json_encode(array('statusCode'=>1045,'statusMsg'=>'验证码或手机号错误'));

        if(($send_code==$save_code) && ($send_mobile==$save_mobile)){
            $result = json_encode(array('statusCode'=>"000000",'statusMsg'=>'true'));
        }
       echo $result;
    }


    public function actionUrl(){

        return $this->redirect('/17-files');
    }

}
