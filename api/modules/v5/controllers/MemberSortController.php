<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/10
 * Time: 10:07
 */

namespace api\modules\v5\controllers;
use yii;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;

class MemberSortController extends ActiveController
{
    public $modelClass = 'api\modules\v5\models\MemberSort';

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
        $result = $modelClass->find()->where(['flag'=>1])->orderby(' id DESC ')->all();
        $lunbo = (new Query())->from('{{%app_lunbo}}')->where('')->all();
        $str = array(
            'member' => $result,
            'is_status' => 0,
            'lunbo' =>  $lunbo,
        );
        return $str;
    }

    public function actionView($id){


    }

}