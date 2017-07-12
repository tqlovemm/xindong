<?php

namespace frontend\modules\weixin\controllers;
use yii\web\Controller;

class ArticleController extends Controller
{

    public $layout = false;

    public function actionBoy(){
        return $this->render('boy');
    }
   public function actionGirl(){

        return $this->render('girl');
    }
   public function actionFlop(){

        return $this->render('flop');
    }
   public function actionSign(){

        return $this->render('sign');
    }
    public function actionApp(){

        return $this->render('app');
    }
    public function actionFriends(){

        return $this->render('friends');
    }
    public function actionWechat(){

        return $this->render('wechat');
    }
   public function actionGou(){

        return $this->render('gou');
    }
   public function actionFeedback(){

        return $this->render('feedback');
    }
   public function actionIdPhoto(){

        return $this->render('id-photo');
    }

}
