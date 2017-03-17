<?php

namespace api\modules\v2\controllers;

use api\modules\v2\models\User;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\base\ErrorException;
use yii\db\Query;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\helpers\Response;

class User1Controller extends ActiveController
{
    public $modelClass = 'api\modules\v2\models\User1';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',

    ];

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        // token 验证  请按需开启
         /*$behaviors['authenticator'] = [
             'class' => CompositeAuth::className(),
             'authMethods' => [
                 QueryParamAuth::className(),
             ],
         ];*/
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

    public function actionCreate()
    {
       /* $model = new $this->modelClass();
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }

        return $model;*/
        Response::show(401,'不允许的操作');

    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $pre_url = Yii::$app->params['appimages'];
        $avatar_path = $model->avatar;
        $model->load(Yii::$app->getRequest()->getBodyParams(), '');
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        if(!empty(Yii::$app->request->post('avatar'))){

            $pathStr = "uploads";
            $savePath = $pathStr.'/'.time().rand(1,10000).'.jpg';
            file_put_contents($savePath,base64_decode($model->avatar));

            $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.md5($id).rand(1000,9999);
            $qiniu = $qn->upload_app('appimages',"uploads/user/avatar/$mkdir",$savePath);

            @unlink($savePath);
            $model->avatar = $pre_url.$qiniu['key'];
        }

        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }
        if(!empty($avatar_path)){
            try{
                $avatar_path = str_replace($pre_url,'',$avatar_path);
                $qn->delete('appimages',$avatar_path);
            }catch (ErrorException $e){

            }
        }
        return $model;
    }

    public function actionDelete($id)
    {
        /*return $this->findModel($id)->delete();*/
        Response::show(401,'不允许的操作');
    }

    public function actionView($id)
    {

        $model = $this->findModel($id);


        if(!is_numeric($id)){

            if(isset($_GET['uid'])){
                $uid = $_GET['uid'];
                $follow = Yii::$app->db->createCommand('select * from {{%user_follow}} WHERE user_id='.$uid.' and people_id='.$model['id'])->queryOne();
                if(!empty($follow)){
                    $follow['follow'] = 1;
                    unset($follow['id'],$follow['people_id']);
                }else{

                    $follow['follow'] = 0;
                }

            }else{

                $follow = array();
            }
            $credit = (new Query())->select("levels,viscosity,lan_skills,sex_skills,appearance")->from("{{%credit_value}}")->where(['user_id'=>$model['id']])->one();

            if(empty($credit)){

                Yii::$app->db->createCommand()->insert('{{%credit_value}}',[
                    'user_id'=>$model['id'],
                    'created_at'=>time(),
                    'updated_at'=>time()
                ])->execute();

                $glamorous = 600;

            }else{

                $glamorous = array_sum($credit);
            }


            $data = Yii::$app->db->createCommand('select * from {{%user_data}} WHERE user_id='.$model['id'])->queryOne();
            $profile = Yii::$app->db->createCommand('select *,description as self_introduction from {{%user_profile}} WHERE user_id='.$model['id'])->queryOne();
            unset($model['password_hash'],$profile['description'],$model['auth_key'],$model['password_reset_token'],$model['avatarid'],$model['avatartemp'],$model['id'],$model['role'],$model['identity']);
            $profile['mark']=json_decode($profile['mark']);
            $profile['make_friend']=json_decode($profile['make_friend']);
            $profile['hobby']=json_decode($profile['hobby']);
            $profile['glamorous'] = $glamorous;
            return $model+$data+$profile+$follow;

        }

        return $model;

    }
    protected function findModel($id)
    {
        $modelClass = $this->modelClass;
        if (is_numeric($id)) {
            $model = $modelClass::findOne($id);
        } else {
            $model = $modelClass::find()->where(['username' => $id])->asArray()->one();
        }

        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
