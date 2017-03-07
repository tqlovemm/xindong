<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/24
 * Time: 14:59
 */

namespace api\modules\v10\controllers;

use api\modules\v2\models\Profile;
use api\modules\v2\models\User;
use Yii;
use yii\db\Query;
use yii\myhelper\Response;
use yii\rest\Controller;

class UserLoginController extends Controller
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const ROLE_USER = 10;
    public $modelClass = 'api\modules\v3\models\Login';
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
    public static function findByUsername($username)
    {
        if(is_numeric($username)) {

            $param = 'cellphone';

        }else{

            $param = 'username';
        }

        return User::findOne([$param => $username, 'status' => self::STATUS_ACTIVE]);
    }

    public function actionView($id){

        $user = self::findByUsername($id);
        $password = Yii::$app->request->get('password');
        $cid = Yii::$app->request->get('cid');

        if($user){

            $hash = Yii::$app->security->validatePassword($password,$user['password_hash']);
            if($hash){
                if(!empty($cid)&&strlen($cid)>=32){
                    Yii::$app->db->createCommand("update {{%user}} set cid='$cid' where username='$id'")->execute();

                    $data = $this->getInfo($user['id']);
                    exit(Response::show(202,"login success",$data));
                }
                exit(Response::show(601,"update fail","非法操作"));
            }
            exit(Response::show(403,"password error"));
        }
        exit(Response::show(402,"user does not exist"));

    }

    public function getInfo($id){

        $model = Yii::$app->db->createCommand("select * from pre_user where id = {$id}")->queryOne();
        $uid = isset($_GET['uid'])?$_GET['uid']:0;

        $follow = Yii::$app->db->createCommand("select * from pre_user_follow where user_id = {$uid} and people_id={$model['id']}")->queryOne();
        if(!$follow){
            $follow['follow'] = 0;
        }else{
            $follow['follow'] = 1;
            unset($follow['id'],$follow['people_id']);
        }

        $credit = (new Query())->select('levels,viscosity,lan_skills,sex_skills,appearance')->from('{{%credit_value}}')->where(['user_id'=>$model['id']])->one();
        if(empty($credit)) {

            Yii::$app->db->createCommand()->insert('{{%credit_value}}', [
                'user_id' => $model['id'],
                'created_at' => time(),
                'updated_at' => time()
            ])->execute();

            $glamorous = 600;
        }else{
            $glamorous = array_sum($credit);
        }
        $data = Yii::$app->db->createCommand('select * from {{%user_data}} WHERE user_id='.$model['id'])->queryOne();
        //未读帖子数
        $count = (new Query())->select('id')->from('{{%app_message}}')->where(['to_id'=>$id,'action'=>2])->count();
        $data['feed_count']=$count;
        $profile = Yii::$app->db->createCommand('select *,description as self_introduction from {{%user_profile}} WHERE user_id='.$model['id'])->queryOne();
        if(!$profile){
            $model2 = new Profile();
            $model2->user_id = $id;
            $model2->created_at = time();
            $model2->updated_at = time();
            $model2->save();
        }
        unset($model['invitation'],$model['weibo_num'],$profile['description'],$model['auth_key'],$model['password_reset_token'],$model['id'],$model['role'],$model['identity']);
        $profile['mark']= empty($profile['mark'])?array():json_decode($profile['mark']);
        $profile['make_friend']=empty($profile['make_friend'])?array():json_decode($profile['make_friend']);
        $profile['hobby']=empty($profile['hobby'])?array():json_decode($profile['hobby']);
        $profile['glamorous'] = $glamorous;

        $img_url = (new Query())->select('img_url')->from('pre_user_image')->where(['user_id'=>$id])->all();
        $row = array();
        foreach($img_url as $list){
            $row[] = $list['img_url'];
        }
        $ims['photos'] = $row;

        return $model+$data+$profile+$follow+$ims;
    }
}