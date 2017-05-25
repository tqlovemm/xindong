<?php

namespace backend\modules\dating\controllers;

use api\modules\v9\models\AppSpecialDatingSignUp;
use backend\modules\dating\models\AppSpecialDating;
use yii\data\Pagination;
use yii\myhelper\AccessToken;
use yii\web\NotFoundHttpException;

class AppSpecialDatingSignupController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $data = AppSpecialDatingSignUp::find()->with('zinfo')->with('cover')->asArray();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();
        return $this->render('index',[
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    public function actionSignupCheck($id,$status){
        $model = $this->findModel($id);
        $zinfo = AppSpecialDating::findOne(['zid'=>$model->sid]);
        $model->status = $status;
        if($model->update()){
            if($status==1){
                $this->sendApp($zinfo->weima,'xdd','测试测试');
            }

            return $this->redirect(\Yii::$app->request->referrer);
        }
    }

    protected function sendApp($img,$username,$word="您的密约报名成功，请及时添加女生二维码！"){

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
