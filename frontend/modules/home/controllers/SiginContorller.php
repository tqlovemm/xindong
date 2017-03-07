<?php

namespace app\modules\home\controllers;
use Yii;
use app\modules\home\models\Sigin;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;


class SiginController extends Controller
{

    public function actionIndex(){

      return $this->render('index');

    }



}