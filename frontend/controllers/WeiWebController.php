<?php

namespace frontend\controllers;

use frontend\models\DatingSignupWeichat;
use Yii;
use yii\web\Controller;
use backend\modules\dating\models\Dating;
use frontend\models\WechatDatingSignup;
use yii\data\Pagination;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\myhelper\Address;
class WeiWebController extends Controller
{

    public function actionIndex(){

        $this->layout = false;

        $user_info = json_decode(Yii::$app->request->get('userInfo'),true);

        return $this->render('index');

    }

    public function actionWeb($like_id){

        $model = Yii::$app->db->createCommand("select updated_at,expire from {{%weekly}} where number='{$like_id}'")->queryOne();
        $expire = $model['expire']*3600;
        $duration = $model['updated_at']+$expire-time();
        if($duration<0){
            throw new ForbiddenHttpException;
        }


        $options = array(
            'appid'=>Yii::$app->params['appid'],
        );

        $callback = "http://13loveme.com/wei-web/callback?like_id=$like_id";

        $callback = urlencode($callback);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";

        return $this->redirect($url);

    }
    public function actionWebOpenid($like_id){

        $check = Yii::$app->db->createCommand("select * from {{%dating_signup_weichat}} where like_id='$like_id'")->queryOne();

        if(empty($check)){

            throw new ForbiddenHttpException;
        }

        $options = array(
            'appid'=>Yii::$app->params['appid'],
        );

        $callback = "http://13loveme.com/wei-web/callback2?like_id=$like_id";

        $callback = urlencode($callback);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";

        return $this->redirect($url);

    }

    public function actionCallback2($like_id){

        $data['code'] = Yii::$app->request->get('code');
        $options = array(
            'appid'=>Yii::$app->params['appid'],
            'appsecret'=>Yii::$app->params['appsecret'],

        );

        if(!empty($data['code'])){

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";

            $access = file_get_contents($url);

            $result = json_decode($access,true);

            $result['like_id'] = $like_id;

            $result['service_openid'] = Yii::$app->params['service_openid'];

            return $this->redirect(['ds-gu','info'=>json_encode($result)]);

        }

    }
    public function actionCallback(){

        $options = array(
            'appid'=>Yii::$app->params['appid'],
            'appsecret'=>Yii::$app->params['appsecret'],

        );
        $data['code'] = Yii::$app->request->get('code');
        $data['state'] = Yii::$app->request->get('state');


        if(!empty($data['code'])){

            $url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid={$options['appid']}&secret={$options['appsecret']}&code={$data['code']}&grant_type=authorization_code";

            $access = file_get_contents($url);

            $result = json_decode($access);

            $access_token = $result->access_token;

            $openid = $result->openid;

            $url2 = "https://api.weixin.qq.com/sns/userinfo?access_token={$access_token}&openid={$openid}&lang=zh_CN";


            $userInfo = file_get_contents($url2);

            if(!empty($userInfo)){

                $userInfo = json_decode($userInfo,true);
                $userInfo['like_id'] = Yii::$app->request->get('like_id');

                return $this->redirect(['dating-signup','userInfo'=>json_encode($userInfo)]);

            }
        }

    }


    public function actionDateToday(){

        $this->layout='/basic';
        //$max = Yii::$app->db->createCommand("select max(created_at) as maxtime from {{%weekly}} WHERE status=2")->queryOne();
        $groupid = isset(Yii::$app->user->identity->groupid)?Yii::$app->user->identity->groupid:'';
        // $query = Yii::$app->db->createCommand("select * from {{%weekly}} where status=2 order by updated_at DESC limit 0,20")->;
        $query = Dating::find()->select('id,number,title,content,url,created_at,avatar')->where(['status' => 2,'cover_id'=>0])->orderBy('updated_at DESC');
        //$countQuery = clone $query;
        $pages = new Pagination(['totalCount' => 25,'pageSize' => '8']);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('date-today',['model'=>$models,'pages' => $pages,'groupid'=>$groupid]);

    }
    public function actionRed(){

        $address = new Address();
        $locs =  $address->getAddress();

        $loc = "'$locs'";

        if(!empty($loc)){

            $query = Yii::$app->db->createCommand("select title from {{%weekly}} where title=$loc")->queryOne();

            if(!empty($query)){

                $cid = $query['title'];

            }else{

                $cid = "北京";
            }
        }

        return $this->redirect('date-past?title='.$cid.'&company=13pt');
    }
    public function actionDatePast($title){

        $this->layout='/basic';
        $groupid = isset(Yii::$app->user->identity->groupid)?Yii::$app->user->identity->groupid:'';
        $query = Dating::find()->select('id,number,title,content,url,created_at,avatar')->where(['status' => 2,'cover_id'=>0,'title'=>$title])->orderBy('updated_at desc');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        if (($model = Dating::findOne(['status'=>2])) !== null) {
            $mod =  $model;
        } else {
            throw new NotFoundHttpException('请求的页面不存在。');
        }

        return $this->render('date-past',['model'=>$models,'pages' => $pages,'mod'=>$mod,'groupid'=>$groupid]);

    }
    public function actionDateView($id){

        $this->layout='/basic';

        $dating = new Dating();

        $area = $dating->getArea($id);

        $contents = $dating->getContent($id);

        $photos = $dating->getPhoto($id);

        return $this->render('date-view',[

            'area'=>$area,
            'contents'=>$contents,
            'photos'=>$photos,
            'weekly_id'=>$id,

        ]);

    }

    public function actionDatingSignup(){

        $model = new WechatDatingSignup();
        $user_info = json_decode(Yii::$app->request->get('userInfo'),true);

        if($model->load(Yii::$app->request->post())&&$model->validate()){

            $number = (string)$model->number;
            $weekly = Yii::$app->db->createCommand("select title from {{%weekly}} where number='{$user_info['like_id']}'")->queryOne();
            $file = Yii::$app->db->createCommand("select * from {{%flop_content}} where number='{$number}' and area='{$weekly['title']}'")->queryOne();

            $signupes = WechatDatingSignup::findOne(['like_id'=>$user_info['like_id']]);

           if(empty($file)){

                throw new ForbiddenHttpException;

            }
            $extra = array('image'=>$file['content'],'area'=>$file['area'],'number'=>$file['number'],'height'=>$file['height'],'weight'=>$file['weight']);

            $model->openid = $user_info['openid'];
            $model->like_id = $user_info['like_id'];
            $model->extra = json_encode($extra);

            if($model->save()){

                Yii::$app->db->createCommand()->insert('{{%dating_signup_weichat_record}}',[
                    'like_id'=>$user_info['like_id'],
                    'service_openid'=>Yii::$app->params['service_openid'],
                ])->execute();

                if(!empty($signupes)){

                   return $this->render('success');//该女生已经存在报名，不需要推送微信给客服

                }

                return $this->redirect(["/wei-xin/send-to-cs",'like_id'=>$model->like_id]);//第一个报名，推送微信给客服

            }

        }

        return $this->render("_dating_signup",['model'=>$model,'user_info'=>$user_info]);
    }

    public function actionSuccess(){


        return $this->render("success");

    }

    public function actionDsGu($info=null){

        if($info==null){
            throw new NotFoundHttpException;
        }

        $info = json_decode($info,true);

        $record = Yii::$app->db->createCommand("select * from {{%dating_signup_weichat_record}} where like_id='{$info['like_id']}'")->queryOne();

        $allow = array($record['openid'],$record['service_openid']);

        if(!empty($record)&&empty($record['openid'])&&$info['openid']!=$info['service_openid']){

            Yii::$app->db->createCommand()->update('{{%dating_signup_weichat_record}}',[
                'openid'=>$info['openid'],
                'service_openid'=>$info['service_openid'],
            ],"like_id='{$info['like_id']}'")->execute();

        }elseif(!in_array($info['openid'],$allow)){

            throw new ForbiddenHttpException;
        }
        $query = DatingSignupWeichat::find()->select('id,extra,like_id,status,created_at')->where(['like_id'=>$info['like_id']])->andWhere('status!=3');
        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $models = $query->offset($pages->offset)->orderBy('created_at desc')
            ->limit($pages->limit)->asArray()
            ->all();

        return $this->render('ds-gu', [
            'models' => $models,
            'pages' => $pages,
        ]);

    }

    public function actionAjaxOperation($status,$id,$like_id=''){

        $query = Yii::$app->db->createCommand("select status from {{%dating_signup_weichat}} where id=".$id)->queryOne();

        if($query['status']==$status){

            Yii::$app->db->createCommand()->update('{{%dating_signup_weichat}}',['status'=>0],'id='.$id)->execute();

        }else{

            Yii::$app->db->createCommand()->update('{{%dating_signup_weichat}}',['status'=>$status],'id='.$id)->execute();
            $num = Yii::$app->db->createCommand("select status from {{%dating_signup_weichat}} where like_id='{$like_id}' and status!=3")->queryAll();
            echo count($num);
        }

    }

    public function actionWxpay(){


        $options = array(
            'appid'=>Yii::$app->params['appid'],
        );

        $callback = "http://13loveme.com/weipay";

        $callback = urlencode($callback);

        $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid={$options['appid']}&redirect_uri={$callback}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";

        return $this->redirect($url);

    }


    public function actionWeipay(){


        return var_dump($_GET);


    }

}