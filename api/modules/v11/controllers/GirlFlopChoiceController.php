<?php
namespace api\modules\v11\controllers;

use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;

class GirlFlopChoiceController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\GirlFlop';
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    public function actionView($id)
    {
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $query = (new Query())->select('shortname')->from('{{%member_address_link}}')->where(['parentid'=>0])->all();
        $new = array();
        for($i=0;$i<count($query);$i++){
            $new[] = $query[$i]['shortname'];
        }
        return array('code'=>'200','message'=>'ok','data'=>$new);
    }
}

