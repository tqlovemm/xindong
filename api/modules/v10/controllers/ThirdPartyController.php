<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/2/27
 * Time: 13:55
 */

namespace api\modules\v10\controllers;

use api\modules\v2\models\Profile;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\db\Query;
use yii\myhelper\Easemob;
use yii\myhelper\Response;
use yii\rest\Controller;
use yii\web\NotFoundHttpException;

class ThirdPartyController extends Controller
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

    protected function UploadImg($img){

        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $avatar = base64_decode($img);
        $path_1 ='uploads/';
        $t = time();
        $pre_url = Yii::$app->params['appimages'];
        file_put_contents($path_1.$t.'.jpg',$avatar);
        $avatar_path = $path_1.$t.'.jpg';
        $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.mt_rand(1000,9999);
        $qiniu = $qn->upload_app('appimages','uploads/user/avatar/'.$mkdir,$avatar_path);
        $url = $pre_url.$qiniu['key'];
        @unlink($avatar_path);
        return $url;

    /*    $img = base64_decode($img);
        $path = '/uploads/user/files/';
        $savePath = Yii::getAlias('@apiweb').$path;
        $saveName = "_".time().'.png';
        $url = Yii::$app->params['hostname'].$path.$saveName;
        file_put_contents($savePath.$saveName,$img,FILE_USE_INCLUDE_PATH);
        return $url;*/
    }

    protected function testChinese($name){

        $ret = preg_match('/^[\x4e00-\x9fa5]+$/', $name);
        return $ret;
    }

    protected function getFindSomeone($param){

        $model = $this->modelClass;
        $res = $model::find()->where($param)->one();
        if($res){
            return true;
        }
        return false;
    }

    public function actionCreate(){

        $model = new $this->modelClass();

        $model->load(Yii::$app->getRequest()->getBodyParams(),'');

        if(!$this->testChinese($model->username)){
            Response::show('201','用户名不能为中文或为空');
        }

        //用户名唯一
        if($this->getFindSomeone(['username'=>$model->username])){
            Response::show('201','用户名已存在');
        }

        //如果接收到的是图片链接直接存储，否则存储图片
        $model->avatar = $this->UploadImg($model->avatar);

        //用户年龄不能为空，不能小于18岁
        $age = date('Y',time())-$model->birthdate;
        if($age<18){
            Response::show('201','年龄太小了');
        }
        $birthdate = $model->birthdate;

        //环信密码
        $model->none = md5("shisan".rand(11111,99999)."pingtai");
        $model->openId = isset($model->openId)?$model->openId:null;
        if(!$model->openId){
            Response::show('201','openId不能为空');
        }

        //openId唯一
        if($this->getFindSomeone(['openId'=>$model->openId])){
            Response::show('201','您已注册过了');
        }

        $address = $model->address;
        if($model != null){
            if($model->save()){
                Yii::$app->db->createCommand("insert into {{%user_data}} (user_id) VALUES ({$model->id})")->execute();
                Yii::$app->db->createCommand("insert into {{%user_profile}} (user_id,birthdate,address) VALUES ({$model->id},'{$birthdate}','{$address}')")->execute();
                $array = ['username'=>$model->username,'password'=>$model->none];
                $this->setMse()->addUser($array);

                //引导注册用户联系客服
                $ids = array();
                $msg = 'Hi，欢迎来到十三平台！我是客服十三，这里是十三app的beta版本。希望能让汉子妹子找到性福，如果有“约”的需要，欢迎跟我聊天，我会推荐优质男女给你哟！（对了，记得关注我们的公众号：心动三十一天，有福利）';
                $ids[] = $model->username;
                $data['target_type']    = 'users';
                $data['target']         = $ids;
                $data['msg']            = ['type'=>'txt','msg'=>$msg];
                $data['from']           = 'shisan-kefu';
                $this->setMse()->sendText($data);

                $info = $this->getInfo($model->id);
                Response::show('200','注册成功',$info);
            }else{
                Response::show('201',array_values($model->getFirstErrors())[0],'数据保存失败');
            }
        }

    }

    public function actionView($id){

        $model = new  $this->modelClass();
        $res = $model->find()->where(['openId'=>$id])->one();

        if($res){
            $cid = Yii::$app->request->get("cid");
            if(isset($cid) && strlen($cid) >=32){
                Yii::$app->db->createCommand("update {{%user}} set cid='{$cid}' where id={$res['id']}")->execute();
            }
            $data = $this->getInfo($res['id']);
            exit(Response::show('200','用户已存在',$data));
        }else{
            exit(Response::show('201','用户未注册'));
        }
    }

    public function actionUpdate($id){

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

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }

    }

    protected function setMse(){

        $option = [
            'client_id' =>  Yii::$app->params['client_id'],
            'client_secret' =>  Yii::$app->params['client_secret'],
            'org_name'  =>  Yii::$app->params['org_name'],
            'app_name'  =>  Yii::$app->params['app_name'],
        ];

        $e = new Easemob($option);
        return $e;
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
        unset($model['invitation'],$model['openId'],$model['weibo_num'],$profile['description'],$model['auth_key'],$model['password_reset_token'],$model['id'],$model['role'],$model['identity']);
        $profile['mark']=json_decode($profile['mark']);
        $profile['make_friend']=json_decode($profile['make_friend']);
        $profile['hobby']=json_decode($profile['hobby']);
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