<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 10:07
 */

namespace api\modules\v6\controllers;
use yii;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class MemberSortController extends ActiveController
{
    public $modelClass = 'api\modules\v6\models\MemberSort';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();
        // 注销系统自带的实现方法
        unset($actions['index'], $actions['update'], $actions['create'], $actions['delete'], $actions['view']);
        return $actions;
    }

    public function actionIndex(){

        $modelClass = new $this->modelClass();
        //$status 审核为1，正常使用为0
        $status = 0;
        $result = $modelClass->find()->where(['flag'=>1])->orderby(' id DESC ')->all();
        $lunbo = (new Query())->from('{{%app_lunbo}}')->where('')->all();
        if($status == 1){
            for($i = 0 ; $i < count($result); $i ++){
                if($i == 0){
                    $result[0]['price_1'] = 4998;
                    $result[0]['giveaway'] = 1880;
                }else if($i == 1){
                    $result[1]['price_1'] = 1998;
                    $result[1]['giveaway'] = 990;

                }
            }

        }
        $str = array(
            'member' => $result,
            'is_status' => $status,
            'lunbo' =>  $lunbo,
        );
        return $str;
    }

    public function actionView($id){


    }

}