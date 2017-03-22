<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 10:43
 */

namespace api\modules\v10\controllers;

use Yii;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;

class FollowController extends Controller
{

    public function actionView($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $user_id = $_GET['user_id'];
        $query = Yii::$app->db->createCommand('select * from {{%user_follow}} where user_id='.$id.' and people_id='.$user_id)->queryOne();
        if(!empty($query)){

            Yii::$app->db->createCommand("delete from {{%user_follow}} where user_id=".$id." and people_id=".$user_id)->execute();
            Yii::$app->db->createCommand("UPDATE {{%user_data}} SET following_count=following_count-1 WHERE user_id=".$id)->execute();
            Yii::$app->db->createCommand("UPDATE {{%user_data}} SET follower_count=follower_count-1 WHERE user_id=".$user_id)->execute();
            Response::show(200,'取消关注');

        }else{

            Yii::$app->db->createCommand("insert into {{%user_follow}} (user_id,people_id) VALUES ({$id},{$user_id})")->execute();
            Yii::$app->db->createCommand("UPDATE {{%user_data}} SET following_count=following_count+1 WHERE user_id=".$id)->execute();
            Yii::$app->db->createCommand("UPDATE {{%user_data}} SET follower_count=follower_count+1 WHERE user_id=".$user_id)->execute();
            $cid = Yii::$app->db->createCommand('select cid,username,nickname from {{%user}} where id='.$id)->queryOne();
            $self = Yii::$app->db->createCommand('select cid,username,nickname from {{%user}} where id='.$user_id)->queryOne();

            if(!empty($cid['cid'])){
                if(empty($cid['nickname'])){
                    $cid['nickname'] = $cid['username'];
                }
                $title = $cid['nickname'].'成了您的粉丝';
                $msg = $cid['nickname'].'成了您的粉丝';
                $date = time();
                $icon = Yii::$app->params['icon'].'/images/app_push/u=3453872033,2552982116&fm=21&gp=0.png';
                $extras = json_encode(array('push_title'=>urlencode($title),'push_content'=>urlencode($msg),'push_type'=>'SSCOMM_FANS'));
                Yii::$app->db->createCommand("insert into {{%app_push}} (type,status,cid,title,msg,extras,platform,response,icon,created_at,updated_at) values('SSCOMM_FANS',2,'$self[cid]','$title','$msg','$extras','all','NULL','$icon',$date,$date)")->execute();

            }

            Response::show(202,'关注成功');

        }
    }
}