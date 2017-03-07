<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/22
 * Time: 14:13
 */

namespace api\modules\v10\controllers;

use api\modules\v2\models\Profile;
use Yii;
use yii\db\Query;
use yii\myhelper\Decode;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class User3Controller extends Controller
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

        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $model = $this->findModel($id);
        $user = (new Query())->select('id')->from('pre_user')->where(['username' => $id])->one();
        if (isset($_GET['uid'])) {
            $uid = $_GET['uid'];
            $follow = Yii::$app->db->createCommand('select * from {{%user_follow}} WHERE user_id=' . $uid . ' and people_id=' . $user['id'])->queryOne();
            if (!empty($follow)) {
                $follow['follow'] = 1;
                unset($follow['id'], $follow['people_id']);
            } else {

                $follow['follow'] = 0;
            }

        } else {

            $follow = array();
        }

        $credit = (new Query())->select("levels,viscosity,lan_skills,sex_skills,appearance")->from("{{%credit_value}}")->where(['user_id' => $model['id']])->one();

        if (empty($credit)) {

            Yii::$app->db->createCommand()->insert('{{%credit_value}}', [
                'user_id' => $model['id'],
                'created_at' => time(),
                'updated_at' => time()
            ])->execute();

            $glamorous = 600;

        } else {

            $glamorous = array_sum($credit);
        }

        $user_id = $model['id'];
        $data = Yii::$app->db->createCommand('select * from {{%user_data}} WHERE user_id=' . $model['id'])->queryOne();
        $data['thread_count']= (new Query())->select('id')->from('{{%app_words}}')->where(['user_id'=>$user['id']])->count();
        //获取帖子未读消息数
        $data['feed_count'] = (new Query())->select('id')->from('{{%app_message}}')->where(['to_id'=>$user['id'],'action'=>2,'is_read'=>1])->count();
        $profile = Yii::$app->db->createCommand('select *,description as self_introduction from {{%user_profile}} WHERE user_id=' . $model['id'])->queryOne();
        if(!$profile){
            $model2 = new Profile();
            $model2->user_id = $id;
            $model2->created_at = time();
            $model2->updated_at = time();
            $model2->save();
        }
        unset($model['password_hash'], $profile['description'], $model['auth_key'], $model['password_reset_token'], $model['avatarid'], $model['avatartemp'], $model['id'], $model['role'], $model['identity']);
        $profile['mark'] = json_decode($profile['mark']);
        $profile['make_friend'] = json_decode($profile['make_friend']);
        $profile['hobby'] = json_decode($profile['hobby']);
        $profile['glamorous'] = $glamorous;

        $photos = Yii::$app->db->createCommand('select img_url from {{%user_image}} WHERE user_id=' . $user_id)->queryAll();
        $imgs = array();
        if (!$photos) {
            $imgs['photos'] = null;
        } else {
            foreach ($photos as $list) {

                $imgs['photos'][] = $list['img_url'];
            }
        }
        return $model + $data + $profile + $follow + $imgs;

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