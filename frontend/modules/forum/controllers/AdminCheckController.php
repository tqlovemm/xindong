<?php
namespace frontend\modules\forum\controllers;

use backend\models\AdminCheck;
use backend\models\User;
use backend\modules\setting\models\AuthAssignment;
use frontend\models\UserData;
use frontend\models\UserProfile;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class AdminCheckController extends Controller
{

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['pass-or-no'],
                'rules' => [
                    [
                        'actions' => ['pass-or-no'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }
    public function actionIndex($id){

        $model = $this->findModel($id);
        return $this->render('index',['model'=>$model]);

    }

    public function actionPassOrNo($id,$status,$type){

        if(in_array(\Yii::$app->user->id,AuthAssignment::find()->select('user_id')->column())){
            $model = $this->findModel($id);
            $model->status = $status;
            $model->checker = \Yii::$app->user->id;
            if($type==1){
                if($status==2){
                    $userData = UserData::findOne($model->user_id);
                    $userData->jiecao_coin+=$model->coin;
                    if(!$userData->update()){
                        $model->status = 1;
                        return var_dump($userData->errors);
                    }
                }
            }else{
                if($status==2){
                    $user = User::findOne($model->user_id);
                    $user->groupid =$model->vip;
                    if(!$user->update()){
                        $model->status = 1;
                        return var_dump($user->errors);
                    }
                }
            }
            $model->update();
            return $this->redirect(['index','id'=>$id]);
        }
        throw new ForbiddenHttpException('The requested page does not exist.');
    }

    protected function findModel($id)
    {
        if (($model = AdminCheck::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
