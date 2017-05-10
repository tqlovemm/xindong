<?php
namespace frontend\controllers;
use Yii;
use yii\web\Controller;

class AppController extends Controller
{

    public function actionIndex(){

        return $this->redirect('http://seventeenyj.com/bgadmin/seventeen-man/seventeen');
    }

}