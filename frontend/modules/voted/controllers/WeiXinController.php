<?php
namespace app\modules\voted\controllers;

use Yii;
use yii\web\Controller;
//use frontend\controllers\WeiXinController;

class WeiXinController extends Controller
{
    public function actionIndex()
    {
        return $this->render('index');
    }
}
