<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/21
 * Time: 17:01
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class UfollowController extends Controller
{

    public $modelClass = 'api\modules\v2\models\Ufollow';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

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

    public function actionView($id)
    {

        $following = $this->findModels2($id);   //喜欢
        $follower = $this->findModels($id);    //粉丝

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $er = array();
        $ing = array();
        if(!empty(count($follower))){

            for($i=0;$i<count($follower);$i++){

                $uid = $follower[$i]['user_id'];
                $command = Yii::$app->db->createCommand('SELECT u.id as user_id,u.groupid,u.username,u.nickname,u.email,u.cellphone,u.sex,u.status,u.avatar,u.created_at,
                                                        ud.post_count,ud.feed_count,ud.following_count,ud.follower_count,ud.thread_count,ud.empirical_value,ud.unread_message_count,
                                                        up.birthdate,up.signature,up.address,up.description as self_introduction,up.mark,up.make_friend,up.hobby,up.height,up.weight
                                                        FROM {{%user}} as u LEFT JOIN {{%user_data}} as ud ON ud.user_id=u.id LEFT JOIN {{%user_profile}} as up ON up.user_id=u.id WHERE id='.$uid);
                $post = $command->queryOne();

                $to = Yii::$app->db->createCommand('select * from {{%user_follow}} WHERE user_id='.$uid.' and people_id='.$id)->execute();
                $from = Yii::$app->db->createCommand('select * from {{%user_follow}} WHERE user_id='.$id.' and people_id='.$uid)->execute();

                $post['mark'] = json_decode($post['mark']);
                $post['make_friend'] = json_decode($post['make_friend']);
                $post['hobby'] = json_decode($post['hobby']);

                if($to&&$from){

                    $post['each']=1;
                }else{

                    $post['each']=0;
                }

                array_push($er,$post);

            }
        }
        if(!empty(count($following))){

            for($i=0;$i<count($following);$i++){

                $uid = $following[$i]['people_id'];
                $command = Yii::$app->db->createCommand('SELECT u.id as user_id,u.groupid,u.username,u.nickname,u.email,u.cellphone,u.sex,u.status,u.avatar,u.created_at,
                                                        ud.post_count,ud.feed_count,ud.following_count,ud.follower_count,ud.thread_count,ud.empirical_value,ud.unread_message_count,
                                                        up.birthdate,up.signature,up.address,up.description as self_introduction,up.mark,up.make_friend,up.hobby,up.height,up.weight
                                                        FROM {{%user}} as u LEFT JOIN {{%user_data}} as ud ON ud.user_id=u.id LEFT JOIN {{%user_profile}} as up ON up.user_id=u.id WHERE id='.$uid);
                $post = $command->queryOne();


                $to = Yii::$app->db->createCommand('select * from {{%user_follow}} WHERE user_id='.$uid.' and people_id='.$id)->execute();
                $from = Yii::$app->db->createCommand('select * from {{%user_follow}} WHERE user_id='.$id.' and people_id='.$uid)->execute();

                $post['mark'] = json_decode($post['mark']);
                $post['make_friend'] = json_decode($post['make_friend']);
                $post['hobby'] = json_decode($post['hobby']);
                if($to&&$from){

                    $post['each']=1;
                }else{

                    $post['each']=0;
                }

                array_push($ing,$post);

            }
        }

        $follow['following'] = $ing;
        $follow['follower'] = $er;

        return $follow;
    }

    protected function findModels2($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::find()->where('user_id='.$id)->asArray()->all()) !== null) {

            return $model;

        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModels($id)
    {
        $modelClass = $this->modelClass;
        if (($model = $modelClass::find()->where('people_id='.$id)->asArray()->all()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}