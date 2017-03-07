<?php
namespace api\modules\v8\controllers;

use Yii;
use yii\helpers\Response;
use yii\myhelper\Easemob;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;

class UserController extends ActiveController
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

        $img = base64_decode($img);
        $path = '/uploads/user/files/';
        $savePath = Yii::getAlias('@apiweb').$path;
        $saveName = "_".time().'.png';
        $url = Yii::$app->params['hostname'].$path.$saveName;
        file_put_contents($savePath.$saveName,$img,FILE_USE_INCLUDE_PATH);
        return $url;
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
        //if(strpos($model->avatar,'http:') !== 0){
        $model->avatar = $this->UploadImg($model->avatar);
        //}

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

                $info['id']         = $model->id;
                $info['username']   = $model->username;
                $info['nickname']   = $model->nickname;
                $info['openId']     = $model->openId;
                $info['sex']        = $model->sex;
                $info['birthdate']  = $model->birthdate;
                $info['avatar']     = $model->avatar;
                $info['address']    = $model->address;
                $info['cid']        = $model->cid;
                $info['none']       = $model->none;
                $info['created_at'] = $model->created_at;
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
            $data = [
                'id'    =>  $res['id'],
                'username'    =>  $res['username'],
                'nickname'    =>  $res['nickname'],
                'cid'    =>  $res['cid'],
                'sex'    =>  $res['sex'],
                'address'    =>  $res['address'],
                'openId'    =>  $res['openId'],
                'birthdate'    =>  $res['birthdate'],
                'created_at'    =>  $res['created_at'],
                'none'    =>  $res['none'],
                'avatar'    =>  $res['avatar'],
            ];
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

}