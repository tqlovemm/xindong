<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/5
 * Time: 9:43
 */
namespace frontend\modules\test\controllers;

use frontend\modules\test\models\CheckService;
use Yii;
use yii\web\Controller;

class CheckServiceController extends Controller
{

    public $enableCsrfValidation = false;
    public function actionIndex(){

        $number = Yii::$app->getRequest()->post('number');

        if($number){

            $model = CheckService::findOne(['number'=>$number]);
            if($model){
                return $this->redirect('success?number='.$number);
            }else{
                return $this->redirect('error');
            }
        }

        return $this->render('check');
    }

    public function actionSuccess($number){

        $number = htmlspecialchars($number);
        $model = CheckService::findOne(['number'=>$number]);
        return $this->render('success',['model'=>$model]);
    }

    public function actionError(){

        return $this->render('error');
    }
}