<?php
/*
$bgadmin = new BgadminMember();
$bgadmin->number = $id;
$bgadmin->address_a = $model->address;
$bgadmin->address_b = $model->often_go;
$bgadmin->weicaht = $model->weichat;
$bgadmin->weibo = $model->weibo;
$bgadmin->cellphone = $model->cellphone;
$bgadmin->time = time();
$bgadmin->sex = 0;
$bgadmin->vip = 2;
$bgadmin->save();
*/
namespace frontend\controllers;
use backend\models\User;
use common\components\SaveToLog;
use common\Qiniu\Qfunctions;
use common\Qiniu\QiniuUploader;
use frontend\models\CollectingFilesImg;
use Yii;
use frontend\models\CollectingFilesText;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
class CollectingFilesController extends Controller
{

    public $layout = 'basic';
    public  $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['change-file'],
                'rules' => [
                    [
                        'actions' => ['change-file'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($id=null){

        if(empty($id)){
            throw new ForbiddenHttpException('非法访问');
        }

        $model = new CollectingFilesText();
        $query = $model::find()->where(['flag'=>$id])->asArray()->one();

        try{
            $img = CollectingFilesImg::find()->where(['text_id'=>$query['id']])->orderBy('id desc')->asArray()->all();
        }catch (\Exception $e){
            throw new ForbiddenHttpException('非法访问');
        }

        if(!empty($query)){

            if($query['status']==1||$query['status']==2){
                return $this->render('index-message',['queries'=>$query,'img'=>$img]);
            }
            return $this->render('index',['queries'=>$query,'img'=>$img]);
        }
    }

    public function actionIndexMessage(){

        return $this->render('index');
    }

    public function actionChangeFile(){

        $need_coin = 30;
        $user_id = Yii::$app->user->id;
        $number = User::getNumber($user_id);
        $coin = Yii::$app->db->createCommand("select jiecao_coin from {{%user_data}} where user_id=$user_id")->queryOne();
        if($coin['jiecao_coin']<$need_coin){
            return $this->render("error",['coin'=>$need_coin]);
        }else{

            if(!empty($user_id)&&!empty($number)){
                $model = new CollectingFilesText();
                $query = $model::findOne(['id'=>$number]);
                $query->status = 0;
                if($query->update()){
                    Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin-$need_coin where user_id=$user_id")->execute();
                    try{
                        SaveToLog::userBgRecord("修改档案信息，扣除{$need_coin}节操币");
                    }catch (Exception $e){
                        throw new ErrorException($e->getMessage());
                    }
                }
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionText($id){

        $model = $this->findModel($id);

        if($model->status==1||$model->status==2){
            throw new ForbiddenHttpException('无效链接');
        }

        $model->weichat = Yii::$app->request->post('weichat');
        $model->weibo = Yii::$app->request->post('weibo');
        $model->email = Yii::$app->request->post('email');
        $model->qq = Yii::$app->request->post('qq');
        $model->cellphone = Yii::$app->request->post('cellphone');
        $model->age = strtotime(Yii::$app->request->post('age'));
        $model->height = Yii::$app->request->post('height');
        $model->weight = Yii::$app->request->post('weight');
        $model->hobby = Yii::$app->request->post('hobby');
        $model->annual_salary = Yii::$app->request->post('annual_salary');
        $model->car_type = Yii::$app->request->post('car_type');
        $model->often_go = Yii::$app->request->post('often_go');
        $model->marry = Yii::$app->request->post('marry');
        $model->job = Yii::$app->request->post('job');
        $model->like_type = Yii::$app->request->post('like_type');
        $model->extra = Yii::$app->request->post('extra');

        if($model->update()){
            $model->status = 1;
            $model->update();
            return $this->render('success');
        }
        return $this->render('index');
    }

    public function actionSuccess(){

        return $this->render('success');
    }

    public function actionUploader(){

        $id = Yii::$app->request->post('id');
        $collecting_text = $this->findModel($id);

        if($collecting_text->status==1||$collecting_text->status==2){
            throw new ForbiddenHttpException('无效链接');
        }

        $data = $collecting_text->upload();

        $html = <<<defo
        <img onclick="delete_img($data[id])" src=$data[path] data-id=$data[id] class="preview collecting-files-img">
defo;
        echo $html;
    }
    public function actionUploaderWeima(){

        $id = Yii::$app->request->post('id');
        $collecting_text = $this->findModel($id);

        if($collecting_text->status==1||$collecting_text->status==2){
            throw new ForbiddenHttpException('无效链接');
        }
        $data = $collecting_text->uploadw();

        $html = <<<defo
        <img src=$data[path] data-id=$data[id] class="preview">
defo;
                echo $html;
    }

    public function actionDelete($id){

        $model = $this->findModelImg($id);
        $model->delete();
        $qn = new QiniuUploader('files',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qn->delete('tqlmm',$model->img);
        echo $id;
    }
    public function actionDeleteWeima($id){

        $model = $this->findModel($id);
        $weima =  $model->weima;
        $model->weima = null;
        if($model->update()){
            $qn = new QiniuUploader('files',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $qn->delete('tqlmm',$weima);
        }

    }

    public function actionSendCollectingUrl(){

//        if(in_array(Yii::$app->user->id,[10004,10024])){
 //           throw new ForbiddenHttpException('非法访问');
  //      }
        $model = new CollectingFilesText();

        $query = (new Query())->select('flop_id,area')->from('pre_flop_content')->where(['not in','area',['精选汉子','优质','女生档案']])->all();
        $area = ArrayHelper::map($query,'flop_id','area');

        if($model->load(Yii::$app->request->post())){

            $model->flag = md5(time().md5(rand(10000,99999)));
            $model->flop_id = $model->address;
            $model->address = $area[$model->address];
            if($model->save()){

                $url = "http://13loveme.com/files/";
                return $this->render('send-collecting-url',['model'=>$model,'url'=>$url]);
            }
        }
        return $this->render('_collecting_url',['model'=>$model,'areas'=>$area]);
    }

    public function actionInfo($number=''){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }

        if(!empty($number)){
            
            return $this->redirect('info-detail?id='.$number);
        }

        $data1 = CollectingFilesText::find()->andWhere(['status'=>1]);
        $pages1 = new Pagination(['totalCount' =>$data1->count(), 'pageSize' => '10']);
        $model1 = $data1->offset($pages1->offset)->limit($pages1->limit)->all();

        $data2 = CollectingFilesText::find()->andWhere(['status'=>2]);
        $pages2 = new Pagination(['totalCount' =>$data2->count(), 'pageSize' => '10']);
        $model2 = $data2->offset($pages2->offset)->limit($pages2->limit)->all();

        $data3 = CollectingFilesText::find()->andWhere(['status'=>0]);
        $pages3 = new Pagination(['totalCount' =>$data3->count(), 'pageSize' => '10']);
        $model3 = $data3->offset($pages3->offset)->limit($pages3->limit)->all();

        return $this->render('info',[
            'model1' => $model1,
            'pages1' => $pages1,
            'model2' => $model2,
            'pages2' => $pages2,
            'model3' => $model3,
            'pages3' => $pages3,
        ]);
    }

    public function actionPass($id){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }
        $model = $this->findModel($id);
        $model->status = 2;
        if($model->update()){
            return $this->redirect(['info']);
        }else{
            return var_dump($model->errors);
        }
    }

    public function actionNoPass($id){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }
        $model = $this->findModel($id);
        $model->status = 0;
        if($model->update()){
            return $this->redirect(['info']);
        }else{
            return var_dump($model->errors);
        }
    }



    public function actionInfoDetail($id){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }
        $model = $this->findModel($id);
        $img = $model->imgs;
        return $this->render('info-detail',['model'=>$model,'img'=>$img]);
    }

    protected function findModel($id)
    {
        if (($model = CollectingFilesText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelImg($id)
    {
        if (($model = CollectingFilesImg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
