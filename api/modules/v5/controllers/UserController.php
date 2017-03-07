<?php
namespace api\modules\v5\controllers;
use Yii;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\myhelper\Easemob;
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/8/2
 * Time: 10:57
 */
class UserController extends ActiveController
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

    public function actionIndex()
    {

        $modelClass = $this->modelClass;
        $query = $modelClass::find();
        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }

    protected function findUsername($username){

        $modelClass = $this->modelClass;
        if(is_numeric($username)){
            $param = 'cellphone';
        }else{
            $param = 'username';
        }
        $model = new $modelClass;

        return $model::findOne([$param=>$username]);
    }

    //用户登录
    public function actionView($id)
    {

        $password = Yii::$app->request->get('password_hash');
        $model = $this->findUsername($id);
        if(empty($model)){

            throw new ForbiddenHttpException('username blank');
        }
        $hash = Yii::$app->security->validatePassword($password, $model->password_hash);

        if($hash){

            return $model;
        }
        throw new ForbiddenHttpException('password error');
    }

    //更新用户信息
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        return $model;
    }


    //用户注册
    public function actionCreate()
    {

        /**
         * cellphone,password_hash,avatar,sex,birthdate,username.
         */
        $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if(!(isset($model->password_hash) && !empty($model->password_hash))){
            $str = array(
                'code'  =>  '201',
                'msg'   =>  '注册失败',
                'data'  =>  '密码不能为空',
            );
            return $str;
        }
        $model->password_hash = Yii::$app->security->generatePasswordHash($model->password_hash);

        $age = strtotime($model->birthdate);
        //判断年龄
        $age = date('Y',time())-date('Y',$age);
        if($age<18) {
            $str = array(
                'code'  =>  '201',
                'msg'   =>  '注册失败',
                'data'  =>  '年龄不能小于18岁',
            );
            return $str;
        }
        $model->nickname = $model->username;
        $model->none = $model->password_hash;

        $avatar = base64_decode($model->avatar);
        $path_1 ='/uploads/user/avatar/';
        $path = Yii::getAlias('@apiweb').$path_1;
        $t = time();
        file_put_contents($path.$t.'.jpg',$avatar,FILE_USE_INCLUDE_PATH);
        $model->avatar = Yii::$app->params['hostname'].$path_1.$t.'.jpg';

        if (!$model->save()) {
            $str = array(
                'code'  =>  '201',
                'msg'   =>  '注册失败',
                'data'  =>  array_values($model->getFirstErrors())[0],
            );
            return $str;
        }

        //新添的id值
        $user_id = $model->primaryKey;

        //环信注册
        $array = ['username'=>$model->username,'password'=>$model->none];
        $this->setMes()->addUser($array);


        $str = array(
            'code'  =>  '200',
            'msg'   =>  '注册成功',
            'data'  =>  $model,
        );

        Yii::$app->db->createCommand()->insert('pre_user_profile',['user_id'=>$user_id,'birthdate'=>$model->birthdate])->execute();
        Yii::$app->db->createCommand()->insert('pre_user_data',['user_id'=>$user_id])->execute();

        //引导注册用户联系客服
        $ids = array();
        $msg = 'Hi，欢迎来到十三平台！我是客服十三，这里是十三app的beta版本。希望能让汉子妹子找到性福，如果有“约”的需要，欢迎跟我聊天，我会推荐优质男女给你哟！（对了，记得关注我们的公众号：心动三十一天，有福利）';
        $ids[] = $model->username;
        $data['target_type']= 'users';
        $data['target'] = $ids;
        $data['msg'] = ['type'=>'txt','msg'=>$msg];
        $data['from'] = 'shisan-kefu';//shisan-kefu
        $this->setMes()->sendText($data);
        return $str;
    }

    public function actionDelete($id)
    {
        //$model = new $this->modelClass();
        //$model->load(Yii::$app->getRequest()->getBodyParams(), '');
        return $this->findModel($id)->delete();
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



}