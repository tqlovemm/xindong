<?php
namespace frontend\modules\test\controllers;

use api\modules\v1\models\User;
use frontend\modules\test\models\UserHowPlay;
use Yii;
use yii\web\Controller;
class UserHowPlayController extends Controller
{

    public function actionIndex(){

        $userId = Yii::$app->user->id;
        if(!$userId){

            //未登陆
            return $this->redirect('/login');
        }else{

            $groupId = User::findOne(['id'=>$userId]);
            if(in_array($groupId['groupid'],[3,4])){
                //高级会员
                $model = UserHowPlay::findOne(['flag'=>1]);
                return $this->render('index',['model'=>$model]);

            }elseif($groupId['groupid'] == 2){
                //普通会员
                $model = UserHowPlay::findOne(['flag'=>2]);
                return $this->render('index2',['model'=>$model]);

            }else{
                return $this->redirect('/');
            }
        }

    }

}