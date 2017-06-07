<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/24
 * Time: 14:59
 */

namespace api\modules\v10\controllers;

use api\modules\v2\models\Profile;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\db\Query;
use yii\myhelper\Easemob;
use yii\rest\Controller;

class RegisterController extends Controller
{

    public $modelClass = 'api\modules\v5\models\User';
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

    //用户注册
    public function actionCreate()
    {
        $pre_url = Yii::$app->params['appimages'];
        /**
         * cellphone,password_hash,avatar,sex,birthdate,username.
         */
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
   /*     if(empty($model->password_hash)){
            $str = array(
                'code'  =>  '201',
                'message'   =>  '注册失败,密码不能为空',
                'data'  =>  '密码不能为空',
            );
            return $str;
        }*/
        $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);

        $age = strtotime($model->birthdate);
        //判断年龄
        $age = date('Y',time())-date('Y',$age);
        if($age<18) {
            $str = array(
                'code'  =>  '201',
                'message'   =>  '注册失败,年龄不能小于18岁',
                'data'  =>  '年龄不能小于18岁',
            );
            return $str;
        }
        $model->nickname = $model->username;
        $model->none = $model->password_hash;

        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $avatar = base64_decode($model->avatar);
        $path_1 ='uploads/';
        $t = time();
        file_put_contents($path_1.$t.'.jpg',$avatar);
        $avatar_path = $path_1.$t.'.jpg';
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$model->username;
        $qiniu = $qn->upload_app('appimages','uploads/user/avatar/'.$mkdir,$avatar_path);
        $model->avatar = $pre_url.$qiniu['key'];
        @unlink($avatar_path);
        if (!$model->save()) {

            $str = array(
                'code'  =>  '201',
                'message'   =>  '注册失败'.array_values($model->getFirstErrors())[0],
                'data'  =>  array_values($model->getFirstErrors())[0],
            );
            return $str;
        }

        //新添的id值
        $user_id = $model->primaryKey;

        //环信注册
        $array = ['username'=>$model->username,'password'=>$model->none];
        $this->setMes()->addUser($array);

        $data0 = $this->getInfo($user_id);
        $str = array(
            'code'  =>  '200',
            'message'   =>  '注册成功',
            'data'  =>  $data0,
        );

        Yii::$app->db->createCommand()->insert('pre_user_profile',['user_id'=>$user_id,'birthdate'=>$model->birthdate])->execute();
        Yii::$app->db->createCommand()->insert('pre_user_data',['user_id'=>$user_id])->execute();

        //引导注册用户联系客服
        $ids = array();
        $msg = '你终于来了~我等你很久了💕

想要约个好看的ta，快来玩转我们吧，我们有应接不暇的小活动，如小黑屋，周末勾搭群等等尺度大到你想不到️㊙️

快把你想了解的话题告诉我们的知心客服小姐姐吧，app客服没有及时回复的话，你也可以在微信添加shisan-32进行咨询哦🎈';
        $ids[] = $model->username;
        $data['target_type']= 'users';
        $data['target'] = $ids;
        $data['msg'] = ['type'=>'txt','msg'=>$msg];
        $data['from'] = 'shisan-kefu';//shisan-kefu
        $this->setMes()->sendText($data);
        return $str;
    }

    //环信信息
    protected function setMes(){

        $options = array(
            'client_id'  => Yii::$app->params['client_id'],   //你的信息
            'client_secret' => Yii::$app->params['client_secret'],//你的信息
            'org_name' => Yii::$app->params['org_name'],//你的信息
            'app_name' => Yii::$app->params['app_name'] ,//你的信息
        );
        $e = new Easemob($options);
        return $e;
    }

    public function getInfo($id){

        $model = Yii::$app->db->createCommand("select *,id as user_id from pre_user where id = {$id}")->queryOne();

        $uid = isset($_GET['uid'])?$_GET['uid']:0;

        $follow = Yii::$app->db->createCommand("select * from pre_user_follow where user_id = {$uid} and people_id={$id}")->queryOne();
        if(!$follow){
            $follow['follow'] = 0;
        }else{
            $follow['follow'] = 1;
            unset($follow['id'],$follow['people_id']);
        }

        $credit = (new Query())->select('levels,viscosity,lan_skills,sex_skills,appearance')->from('{{%credit_value}}')->where(['user_id'=>$id])->one();
        if(empty($credit)) {

            Yii::$app->db->createCommand()->insert('{{%credit_value}}', [
                'user_id' => $id,
                'created_at' => time(),
                'updated_at' => time()
            ])->execute();

            $glamorous = 600;
        }else{
            $glamorous = array_sum($credit);
        }
        $data = Yii::$app->db->createCommand('select * from {{%user_data}} WHERE user_id='.$id)->queryOne();
        //未读帖子数
        $count = (new Query())->select('id')->from('{{%app_message}}')->where(['to_id'=>$id,'action'=>2])->count();
        $data['feed_count']=$count;
        $profile = Yii::$app->db->createCommand('select *,description as self_introduction from {{%user_profile}} WHERE user_id='.$id)->queryOne();

        unset($model['invitation'],$model['openId'],$model['weibo_num'],$profile['description'],$model['auth_key'],$model['password_reset_token'],$model['id'],$model['role'],$model['identity']);
        $profile['mark']= empty($profile['mark'])?array():json_decode($profile['mark']);
        $profile['make_friend']= empty($profile['make_friend'])?array():json_decode($profile['make_friend']);
        $profile['hobby']= empty($profile['hobby'])?array():json_decode($profile['hobby']);
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