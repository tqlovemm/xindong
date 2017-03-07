<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/12/13
 * Time: 15:50
 */

namespace api\modules\v8\controllers;

use Yii;
use yii\db\Query;
use yii\myhelper\Response;
use yii\rest\Controller;

class UserInfoController extends Controller
{
    public $modelClass = 'api\modules\v6\models\UpdateUserInfo';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];

    public function behaviors()
    {
        return parent::behaviors();
    }

    public function actions()
    {
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['update'], $actions['create'], $actions['delete']);
        return $actions;
    }

    public function actionView($id)
    {

        $model = $this->findModel($id);
        if(!$model){
            Response::show('201','没有该用户');
        }
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
        if (!$profile['worth']) {
            $profile['worth'] = 50;
        }

        $photos = Yii::$app->db->createCommand('select img_url from {{%user_image}} WHERE user_id=' . $user_id)->queryAll();
        $imgs = array();
        if (!$photos) {
            $imgs['photos'] = null;
        } else {
            foreach ($photos as $list) {

                $imgs['photos'][] = $list['img_url'];
            }
        }
        $str = [
            'code'  =>  200,
            'msg'   =>  $model + $data + $profile + $follow + $imgs
        ];
        return $str;

    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if(is_numeric($id)){
            $model = $modelClass::find()->from('pre_user')->where(['cellphone' => $id])->asArray()->one();
        }else{
            $model = $modelClass::find()->from('pre_user')->where(['username' => $id])->asArray()->one();
        }

        if ($model !== null) {
            return $model;
        } else {
            return null;
        }
    }
}