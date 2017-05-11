<?php
namespace frontend\controllers;

use backend\modules\app\models\AppOrderList;
use yii\web\Controller;

class AppController extends Controller
{
    public function actionIndex($id){
        $model = AppOrderList::findOne($id);
        return $this->render('index',['model'=>$model]);
    }

}