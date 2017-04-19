<?php
namespace api\modules\v11\controllers;

use api\modules\v11\models\FormThreadImages;
use api\modules\v2\models\Ufollow;
use api\modules\v3\models\AppPush;
use api\modules\v3\models\Push;
use common\Qiniu\QiniuUploader;
use yii;
use yii\helpers\Response;
use yii\rest\ActiveController;
use api\components\CsvDataProvider;
use yii\filters\RateLimiter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class FormThreadController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThread';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
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

    /**
     * @return CsvDataProvider
     * 查看所有帖子接口get
     * /v11/form-threads?access-token={cid}
     * 可添加参数筛选/v11/form-threads?access-token={cid}
     * url可选拼接参数：&sex=0 男生发帖 ，&sex=1 女生发帖 不拼接则为全部帖子，
     * &follow=1&user_id={user_id} 关注人的帖子，
     * &tag={tag} 所有该标签的帖子，
     * &people={user_id} 该会员发布的所有帖子，
     * &sort=1 最热帖子排序
     *
     * 若access-token不存在或错误则返回如下
     * {
        "name": "Unauthorized",
        "message": "You are requesting with an invalid credential.",
        "code": 0,
        "status": 401,
        "type": "yii\\web\\UnauthorizedHttpException"
        }
     */
    public function actionIndex() {

    	$model = $this->modelClass;
        $getData = Yii::$app->request->get();
        $query =  $model::find()->where(['type'=>[0,1]]);

        if(isset($getData['sex'])){
            $sex_filter = [(integer)$getData['sex'],2];
            $query =  $query->andWhere(['sex'=>$sex_filter]);
        }

        if(isset($getData['people_id'])){
            $query =  $query->andWhere(['user_id'=>$getData['people_id']]);
        }

        if(isset($getData['follow'])){
            $follow = yii\helpers\ArrayHelper::map(Ufollow::findAll(['user_id'=>$getData['user_id']]),'people_id','people_id');
            $query =  $query->andWhere(['user_id'=>$follow]);
        }

        if(isset($getData['tag'])){
            $query =  $query->andWhere(['tag'=>$getData['tag']]);
        }

        if(isset($getData['sort'])){
            $query =  $query->orderBy('thumbs_count desc');
        }

        return new CsvDataProvider([
            'query' =>  $query,
            'pagination' => [
                'pageSize' => 16,
            ],
            'insert'=> [
                'modelName'=>$model::find()->where('type=2'),
                'rank'=>0
            ],
            'sort' => [
                'defaultOrder' => [
                    'is_top' => SORT_DESC,
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @return mixed
     * 发帖接口post
     * /v11/form-threads?access-token={cid}
     *
     * post 提交，必填字段：user_id,sex；
     * 必填一个字段： content文字内容,base64Images(base64字符串图片，多图片以@分开)；
     * 可选字段：tag（标签）,lat_long(当前地理位置经纬度)
     */
    public function actionCreate() {

        $pre_url = Yii::$app->params['test'];
    	$model = new $this->modelClass();
    	$model->load(Yii::$app->request->getBodyParams(), '');
        if (!$model->save()) {
            Response::show('201',array_values($model->getFirstErrors())[0], $model->getFirstErrors());
        }else{

            $images = array_filter(explode('@',$model->base64Images));
            if(!empty($images)){
                $query = new FormThreadImages();
                $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);

                foreach ($images as $image){

                    $path = '/uploads/user/form_thread/'.$model->user_id.'_'.uniqid('',true).'.png';
                    $savePath = Yii::getAlias('@apiweb').$path;

                    if(file_put_contents($savePath,base64_decode($image),FILE_USE_INCLUDE_PATH)){

                        $imgInfo = getimagesize($savePath);
                        $qiniu = $qn->upload_app('test',$path,$savePath);
                        $_query = clone $query;
                        $_query->thread_id = $model->wid;
                        $_query->img_path = $pre_url.$qiniu['key'];
                        $_query->img_width = $imgInfo[0];
                        $_query->img_height = $imgInfo[1];
                        if($_query->save()){
                            @unlink($savePath);
                        }else{
                            $_query->errors;
                        }
                    }
                }
            }

        /*  $follower = yii\helpers\ArrayHelper::map(Ufollow::findAll(['people_id'=>$model->user_id]),'user_id','user_id');//关注发帖人的粉丝
            $push = new AppPush();
            foreach ($follower as $item){
                $_push = clone $push;
                $_push->cid =
                $icon = 'http://admin.13loveme.com/images/app_push/u=3453872033,2552982116&fm=21&gp=0.png';
                //$extras = json_encode(array('push_title'=>urlencode($title),'push_post_id'=>urlencode($model->id),'push_content'=>urlencode($msg),'push_type'=>'SSCOMM_FANS_THREAD_DETAIL'));
                //Yii::$app->db->createCommand("insert into {{%app_push}} (type,status,cid,title,msg,extras,platform,response,icon,created_at,updated_at) values('SSCOMM_FANS_THREAD_DETAIL',2,'$theCid','$title','$msg','$extras','all','NULL','$icon',$date,$date)")->execute();
            }*/
            Response::show('200','ok');
        }


    }

    /**
     * @param $id
     * @return mixed
     * 查看单条帖子接口get
     * /v11/form-threads/{wid}?access-token={cid}
     * 若帖子不存在则返回如下
     * {
        "name": "Not Found",
        "message": "The requested page does not exist.",
        "code": 0,
        "status": 404,
        "type": "yii\\web\\NotFoundHttpException"
        }
     */
    public function actionView($id) {

       /* $request = Yii::$app->request->getHeaders();
        $authHeader = $request->get('Authorization');
        if ($authHeader !== null && preg_match("/^Bearer\\s+(.*?)$/", $authHeader, $matches)) {

            return $authHeader;
        }*/
        //return $authHeader;
        $model = $this->findModel($id);
        return $model;
    }

    /**
     * @param $id
     * @return mixed
     * 删除帖子接口delete
     * /v11/form-threads/{wid}?access-token={cid}
     *
     * 若帖子不存在则返回如下
     * {
        "name": "Not Found",
        "message": "The requested page does not exist.",
        "code": 0,
        "status": 404,
        "type": "yii\\web\\NotFoundHttpException"
        }
     */

    public function actionDelete($id)
    {
       if($this->findModel($id)->delete()){
           Response::show('200','ok');
        }
    }

    protected function DeleteImg($imgs){
        $pre_url = Yii::$app->params['appimages'];
        $avatar_path = str_replace($pre_url,'',$imgs);
        $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qn->delete('appimages',$avatar_path);
    }

    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }

}

