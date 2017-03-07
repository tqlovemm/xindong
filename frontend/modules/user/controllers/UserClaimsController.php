<?php

namespace app\modules\user\controllers;
use Yii;
use yii\web\Controller;
use app\modules\forum\models\Thread;
use yii\web\NotFoundHttpException;
use app\modules\user\models\UserClaims;

class UserClaimsController extends Controller
{
    public function actionIndex(){
        $model = $this->findModel();
        if($model->load( Yii::$app->request->post())&&$model->validate()){
            if($model->save()){
                Yii::$app->getSession()->setFlash('success', '投诉成功！！');
                return $this->redirect('view');
            }
        }else{
            if(isset($_GET['id'])){
                $thread = new Thread();
                $id =  $_GET['id'];
                $content = $thread::find()->select('id,content,user_id,image_path')->where('id=:id',[':id'=>$id])->asArray()->one();
                $user = $thread->getName($content['user_id']);
                return $this->render('index',[
                    'user'=>$user,
                    'content'=>$content,
                    'model'=>$model,
                ]);
            }else{
                throw new NotFoundHttpException();
            }
        }
    }
    public function actionView(){

        return $this->render('view');
    }

    protected function findModel()
    {
        if (($model = new UserClaims) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}