<?php

namespace backend\modules\dating\controllers;

use frontend\models\UserData;
use Yii;
use api\modules\v9\models\AppSpecialDatingSignUp;
use backend\models\User;
use backend\modules\dating\models\AppSpecialDating;
use backend\modules\dating\models\AppSpecialDatingSignupSearch;
use yii\myhelper\AccessToken;
use yii\web\NotFoundHttpException;

class AppSpecialDatingSignupController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {

        $searchModel = new AppSpecialDatingSignupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }

    public function actionSignupCheck($id,$status){
        $pre_url = \Yii::$app->params['test'];
        $model = $this->findModel($id);
        $zinfo = AppSpecialDating::findOne(['zid'=>$model->zid]);
        $username = User::getUsername($model->user_id);
        $model->status = $status;
        $model->created_by = Yii::$app->user->id;
        if($model->update()){
            if($status==11){
                $this->sendApp($pre_url.$zinfo->weima,$username,"专属女生报名成功，专属女生编号为{$zinfo->zid}，请保存对方微信二维码并添加为好友，祝您交友愉快");
            }else{
                $userData = UserData::findOne($model->user_id);
                $userData->jiecao_coin+=$zinfo->coin;
                if($userData->update()){
                    $this->sendApp($zinfo->getCoverPhoto(),$username,"专属女生报名失败，专属女生编号为{$zinfo->zid}，已退还您心动币{$zinfo->coin}");
                }

            }

            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    protected function sendApp($img,$username,$word="专属女生报名成功，请保存对方微信二维码并添加为好友，祝您交友愉快"){

        $data = array(
            'username'=>$username,
            'imgPath'=>$img,
            'word'=>$word,
        );
        $url = "https://13loveme.com/v9/send-msgs";
        return (new AccessToken())->postData($url,$data);

    }

    protected function findModel($id)
    {
        if (($model = AppSpecialDatingSignUp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
