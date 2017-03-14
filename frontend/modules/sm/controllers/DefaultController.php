<?php

namespace frontend\modules\sm\controllers;

use backend\modules\setting\models\AuthAssignment;
use backend\modules\sm\models\Province;
use backend\modules\sm\models\SmCollectionCount;
use Yii;
use yii\db\Query;
use backend\modules\sm\models\SmCollectionFilesImg;
use backend\modules\sm\models\SmCollectionFilesText;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
class DefaultController extends Controller
{

    public $layout = '/basic';
    public  $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['change-file','send-collection-url'],
                'rules' => [
                    [
                        'actions' => ['change-file','send-collection-url'],
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

        $model = new SmCollectionFilesText();
        $query = $model::find()->where(['flag'=>$id])->asArray()->one();

        try{
            $img = SmCollectionFilesImg::find()->where(['member_id'=>$query['member_id']])->asArray()->all();
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

    public function actionText($id){

        $model = $this->findModel($id);

        if($model->status==1||$model->status==2){
            throw new ForbiddenHttpException('无效链接');
        }

        foreach ($_POST as $key=>$list){
            $model->$key = $list;
        }
        /* $model->weichat = Yii::$app->request->post('weichat');
         $model->weibo = Yii::$app->request->post('weibo');
         $model->email = Yii::$app->request->post('email');
         $model->qq = Yii::$app->request->post('qq');
         $model->cellphone = Yii::$app->request->post('cellphone');
         $model->birthday = Yii::$app->request->post('birthday');
         $model->height = Yii::$app->request->post('height');
         $model->weight = Yii::$app->request->post('weight');
         $model->hobby = Yii::$app->request->post('hobby');
         $model->annual_salary = Yii::$app->request->post('annual_salary');
         $model->car_type = Yii::$app->request->post('car_type');
         $model->often_go = Yii::$app->request->post('often_go');
         $model->marry = Yii::$app->request->post('marry');
         $model->job = Yii::$app->request->post('job');
         $model->extra = Yii::$app->request->post('extra');
        */
         $model->status = 1;

        if($model->update()){
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
        echo $id;
    }
    public function actionDeleteWeima($id){

        $model = $this->findModel($id);
        $model->weima = null;
        $model->update();
    }

    public function actionSendCollectingUrl(){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }
        $model = new SmCollectionFilesText();

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

        $data1 = SmCollectionFilesText::find()->andWhere(['status'=>1]);
        $pages1 = new Pagination(['totalCount' =>$data1->count(), 'pageSize' => '10']);
        $model1 = $data1->offset($pages1->offset)->limit($pages1->limit)->all();

        $data2 = SmCollectionFilesText::find()->andWhere(['status'=>2]);
        $pages2 = new Pagination(['totalCount' =>$data2->count(), 'pageSize' => '10']);
        $model2 = $data2->offset($pages2->offset)->limit($pages2->limit)->all();

        $data3 = SmCollectionFilesText::find()->andWhere(['status'=>0]);
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

    public function actionSendCollectionUrl(){
        $this->layout = "/main";
        if(!in_array(Yii::$app->user->id,AuthAssignment::find()->select('user_id')->column())){

            throw new ForbiddenHttpException('非法访问');
        }

        $model = new SmCollectionFilesText();
        $area = ArrayHelper::map(Province::find()->orderBy('prov_py asc')->asArray()->all(),'prov_name','prov_name');

        if($model->load(Yii::$app->request->post())){

            $countModel = new SmCollectionCount();
            $countModel = $countModel::findOne(['type'=>$model->vip]);
            $count = $countModel->count;

            if($model->vip==1){
                $a = "j1";
            }elseif($model->vip==2){
                $a = "a3";
            }elseif($model->vip==3){
                $a = "a2";
            }elseif($model->vip==4){
                $a = "a1";
            }elseif($model->vip==5){
                $a = "a8";
            }else{
                $a = "error";
            }
            if($count<100){
                $b = "0"."$count";
            }else{
                $b = $count;
            }

            $model->member_id = $a.$b;
            $model->flag = md5(time().md5(rand(10000,99999)));

            if($model->save()){
                $countModel->count += 1;
                if($countModel->update()){
                    $url = "http://13loveme.com/sm?id=";
                    return $this->render('send-collecting-url',['model'=>$model,'url'=>$url]);
                }else{
                    $model::findOne($model->member_id)->delete();
                }
            }
        }
        return $this->render('_collecting_url',['model'=>$model,'areas'=>$area]);

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
        if (($model = SmCollectionFilesText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelImg($id)
    {
        if (($model = SmCollectionFilesImg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}