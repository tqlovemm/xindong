<?php

namespace frontend\controllers;

use Yii;
use frontend\models\Feedback;
use common\components\BaseController;

class AttentionController extends BaseController
{

    public function actionCopyright_notice() {return $this->render('copyright_notice');}
    public function actionPrivacy() {return $this->render('privacy');}
    public function actionDisclaimer() {return $this->render('disclaimer');}
    public function actionProblem() {return $this->render('problem');}
    public function actionSuccess() {return $this->render('feed_success');}
    public function actionWeixin() {return $this->render('weixin');}
    public function actionCooperation() {return $this->render('business_cooperation');}
    public function actionDisclaimers(){return $this->render('disclaimers');}
    /*public function actionFeedback()
    {
        $model = new Feedback();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect('success');

        } else {

            return $this->render('feedback', [
                'model' => $model,
            ]);
        }
    }*/
}