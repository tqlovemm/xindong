<?php

namespace frontend\modules\weixin\controllers;
use backend\modules\bgadmin\models\BgadminMember;
use backend\modules\bgadmin\models\BgadminMemberFiles;
use backend\modules\dating\models\Dating;
use common\components\SaveToLog;
use frontend\models\RechargeRecord;
use frontend\modules\weixin\models\UserWeichat;
use Imagine\Test\Filter\Basic\ResizeTest;
use yii\helpers\ArrayHelper;
use yii\myhelper\AccessToken;
use yii\web\Controller;
use Yii;
class ToController extends Controller
{
    public function actionTab(){


        $this->layout = "/basic";
        return $this->render('tab');

    }


}
