<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/5/10
 * Time: 16:01
 */

namespace backend\modules\setting\controllers;

use backend\modules\setting\models\CreditValue;
use Yii;
use yii\db\Query;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
class MemberShipController extends Controller
{
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'delete', 'update','url','send-url'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(){

        $number = Yii::$app->request->post();
        if(!empty($number['member-number'])){

            $profile = (new Query())->select('user_id')->from("{{%user_profile}}")->where("number=:number",[':number'=>$number['member-number']])->one();

            $model = CreditValue::find()->where(['user_id'=>$profile['user_id']])->asArray()->one();

            if(empty($model)){

                Yii::$app->session->setFlash('empty','查询无此会员信誉度信息');

            }

            return $this->render("index",['model'=>$model,'number'=>$number['member-number']]);

        }


        return $this->render("index");


    }

}