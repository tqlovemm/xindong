<?php
namespace api\modules\v11\controllers;

use yii;
use yii\rest\ActiveController;
use yii\myhelper\Decode;
use yii\filters\RateLimiter;
use common\Qiniu\QiniuUploader;
use yii\myhelper\Response;
use common\components\PushConfig;
use api\modules\v11\models\User;
use yii\db\Query;

class GirlAuthenticationController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\GirlAuthentication';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];

    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    public function actionCreate(){
        $id = Yii::$app->request->getBodyParam('user_id');
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $date = Yii::$app->request->getBodyParam('date');
        $model = new $this->modelClass();
        $authentication = $model->find()->where(['user_id'=>$id])->orderBy("created_at desc")->one();
        if($authentication['status'] == 3){
            Response::show('202','提交失败',"已经提交过了");
        }elseif($authentication['status'] == 1){
            Response::show('202','提交失败',"已经认证成功了");
        }
        $res = $this->UploadVideo($date,$id);
        if(!$res){
            Response::show('201','上传失败',"视频上传失败");
        }
        $model->load(Yii::$app->request->getBodyParams(), '');
        $model->status = 3;
        $model->video_url = $res;
        if(!$model->save()){
            // return $model->getFirstErrors();
            Response::show('201','上传失败',"上传失败");
        }
        //管理员提醒
        $adminres = (new Query())->select('user_id')->from('{{%admin_push}}')->all();
        if(!empty($adminres)){
            $userids = array();
            foreach($adminres as $v){
                $userids[] = $v['user_id'];
            }
            $title = "系统提醒";
            $msg = "有新的女生认证需要审核！";
            $data = array('push_title'=>$title,'push_content'=>$msg,'push_type'=>'SSCOMM_NOTICE');
            $extras = json_encode($data);
            PushConfig::config();
            $puser = User::find()->where(['id'=>$userids])->all();
            foreach($puser as $var){
                $cids[] = $var['cid'];
            }
            pushMessageToList(1, $title, $msg, $extras , $cids);
        }
        Response::show('200','上传成功',"上传成功");
    }
    public function actionView($id){
        $decode = new Decode();
        if(!$decode->decodeDigit($id)){
            Response::show(210,'参数不正确');
        }
        $data = array();
        $res = (new yii\db\Query())->select('content')->from('{{%girl_flop_prompt}}')->one();
        $model = new $this->modelClass();
        $authentication = $model->find()->where(['user_id'=>$id])->orderBy("created_at desc")->one();
        $data['content'] = $res['content'];
        if(!$authentication){
            return array('code'=>201,'message'=>"ok",'data'=>$data);
        }
        $data['is_renzheng'] = $authentication['status'];
        if($authentication['status'] == 1){
            return array('code'=>200,'message'=>"已经认证通过了！",'data'=>$data);
        }elseif($authentication['status'] == 2){
            return array('code'=>201,'message'=>"认证失败！",'data'=>$data);
        }elseif($authentication['status'] == 3){
            return array('code'=>200,'message'=>"正在审核中!",'data'=>$data);
        }

    }
    protected function UploadVideo($date,$user_id){
        $pre_url = Yii::$app->params['appimages'];
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $date = base64_decode($date);
        $path = '/uploads/saveme/';
        $savepath = Yii::getAlias('@apiweb').$path;
        $t = $user_id.'-'.uniqid().'.mp4';
        $savename = $savepath.$t;
        if(file_put_contents($savename,$date,FILE_USE_INCLUDE_PATH)){
            $qiniu = $qn->upload_app('appimages',$path.$t,$savename);
            unlink($savename);
            return $pre_url.$qiniu['key'];
        }else{
            return "";
        }
    }
}

