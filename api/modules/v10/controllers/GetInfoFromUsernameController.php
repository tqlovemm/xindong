<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 14:13
 */

namespace api\modules\v10\controllers;

use api\modules\v11\models\FormThread;
use api\modules\v2\models\Profile;
use backend\modules\app\models\UserData;
use frontend\models\UserProfile;
use Yii;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class GetInfoFromUsernameController extends Controller
{

    public $modelClass = 'api\modules\v8\models\User';
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

        $model = $this->findModel($id);
        $uid = isset($_GET['uid'])?$_GET['uid']:0;
          $decode = new Decode();
          if(!$decode->decodeDigit($id)){
              Response::show(210,'参数不正确');
          }
        $follow = Yii::$app->db->createCommand("select * from pre_user_follow where user_id = {$uid} and people_id={$model['id']}")->queryOne();
        if(!$follow){
            $follow['follow'] = 0;
        }else{
            $follow['follow'] = 1;
            unset($follow['id'],$follow['people_id']);
        }

        $userData = new UserData();
        if(($data = $userData::findOne($model['id']))==null){
            $userData->user_id = $model['id'];
            $userData->save();
            $data = $userData;
        }
        $data = $data->getAttributes();//节操币，粉丝，关注数

        $data['thread_count'] = FormThread::find()->where(['user_id'=>$model['id']])->count();//发帖数

        $userProfile = new UserProfile();
        if(($profile = $userProfile::findOne($model['id']))==null){
            $userProfile->user_id = $model['id'];
            $userProfile->created_at = time();
            $userProfile->updated_at = time();
            $userProfile->save();
            $profile = $userProfile;
        }
        $profile = $profile->getAttributes();

        unset($model['password_hash'],$model['cellphone'],$model['invitation'],$model['openId'],$model['weibo_num'],$model['none'],$profile['description'],$model['auth_key'],$model['password_reset_token'],$model['id'],$model['role'],$model['identity']);
        $profile['mark']=json_decode($profile['mark']);
        $profile['make_friend']=json_decode($profile['make_friend']);
        $profile['hobby']=json_decode($profile['hobby']);
        $profile['glamorous'] = 600;

        $img_url = (new Query())->select('img_url')->from('pre_user_image')->where(['user_id'=>$id])->all();
        $row = array();
        foreach($img_url as $list){
            $row[] = $list['img_url'];
        }
        $ims['photos'] = $row;

        return $model+$data+$profile+$follow+$ims;

    }


    public function actionUpdate($id){

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(),'');
        if(!empty($model->password_reset_token)){
            $res = Yii::$app->db->createCommand("update {{%user}} set password_reset_token = '{$model->password_reset_token}' where id={$id}")->execute();
            if($res){
                Response::show('200','操作成功');
            }else{
                Response::show('201',"操作失败");
            }
        }else{
            Response::show('201','参数值为空');
        }
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        $model = $modelClass::find()->from('pre_user')->where(['username' => $id])->asArray()->one();

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}