<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/31
 * Time: 17:20
 */

namespace frontend\controllers;


use yii\web\Controller;

class WinnerController extends Controller
{

    public function actionIndex(){

        $this->layout = false;

        return $this->render('index');

    }

    public function actionWeibo(){


        return $this->render('weibo');

    }
    public function actionGame(){

        $this->layout = false;
        return $this->render('game');
    }
}