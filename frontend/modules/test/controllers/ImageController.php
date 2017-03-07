<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/30
 * Time: 14:29
 */

namespace frontend\modules\test\controllers;


use yii\web\Controller;

class ImageController extends Controller
{

    public function actionIndex(){

        return $this->render('index');
    }
}