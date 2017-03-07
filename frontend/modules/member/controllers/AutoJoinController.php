<?php

namespace frontend\modules\member\controllers;
use app\components\WxpayComponents;
use backend\modules\recharge\models\AutoJoinPrice;
use Yii;
use frontend\modules\member\models\AutoJoinLink;
use yii\db\Query;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;

class AutoJoinController extends Controller
{
    public $enableCsrfValidation = false;

    public function actionCheck($id){

        $link = AutoJoinLink::findOne(['flag'=>$id,'status'=>0]);
        if($link){

            $this->findCookie($id);
            return $this->redirect('http://r.xiumi.us/stage/v5/2rgTs/19549182');
        }

        throw new ForbiddenHttpException('非法访问');
    }


    public function actionJoinBeforeForm(){

        return $this->render('join-before-form');

    }
    public function actionCheckForm(){

        $set_cookie = Yii::$app->response->cookies;

        $post = Yii::$app->request->post();

        switch ($post['annual_salary']){
            case 1:
                $type = 1;
                break;
            case 2:
                $type = 2;
                break;
            default:
                $type = 3;
        }

        $this->setCookie($type,$set_cookie,'cookie_member_area');
        $this->setCookie($post['cellphone'],$set_cookie,'cookie_member_cellphone');
        $this->setCookie($post['extra'],$set_cookie,'cookie_member_extra');

        return $this->redirect('index');

    }

    public function actionJoinForm(){

        $get_cookie = Yii::$app->request->cookies;

        if(!$get_cookie->has('auto_join_13pt')){

            throw new ForbiddenHttpException('非法访问');
        }

        return $this->render('join-form',['flag'=>$get_cookie->getValue('auto_join_13pt')]);
    }

    public function actionOther(){

        $get_cookie = Yii::$app->request->cookies;
        return var_dump($get_cookie->getValue('auto_join_13pt'));
    }

    public function actionIndex(){

        $this->layout = '@app/themes/basic/layouts/basic';

        $get_cookie = Yii::$app->request->cookies;
        $cellphone = $get_cookie->getValue('cookie_member_cellphone');
        $area = $get_cookie->getValue('cookie_member_area');

        return $this->render('index',['cellphone'=>$cellphone,'area'=>$area]);

    }

    public function actionShowMember(){

        $this->layout = false;
        return $this->render('show-member');
    }

    public function actionFanpai(){

        return $this->render('fanpai');

    }
    public function actionBada(){

        return $this->render('bada');

    }
    public function actionChangjian(){

        return $this->render('changjian');

    }

    function findGet($str){

        $val = !empty($_GET[$str]) ? $_GET[$str] : null;
        return $val;
    }


    protected function findCookie($flag){

        $set_cookie = Yii::$app->response->cookies;
        $get_cookie = Yii::$app->request->cookies;

        if(!$get_cookie->has('auto_join_13pt')){

            $this->setCookie($flag,$set_cookie);
        }
        if($get_cookie->getValue('auto_join_13pt')!=$flag){

            $set_cookie->remove('language');
            $this->setCookie($flag,$set_cookie);
        }
    }

    protected function setCookie($flag,$set_cookie,$name='auto_join_13pt'){

        $set_cookie->add(new \yii\web\Cookie([
            'name' => $name,
            'value' => $flag,
            'expire'=>time()+3600*24*365,
        ]));
    }

    public function actionC(){

        return $this->render('c');
    }
    public function actionD(){

        return $this->render('d');
    }
    public function actionE(){

        return $this->render('e');
    }
  public function actionF(){

        return $this->render('f');
    }

}