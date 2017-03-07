<?php

namespace frontend\controllers;
use frontend\models\CollectingSeventeenFilesImg;
use frontend\models\CollectingSeventeenFilesText;
use Yii;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class CollectingSeventeenFilesController extends Controller
{

    public $layout = 'basic';
    public  $enableCsrfValidation = false;

    public function actionIndex(){

        $session = Yii::$app->session;
        if(!$session->isActive)
            $session->open();
        $save_code = $session->get('code');
        $save_mobile = $session->get('mobile');

        if(empty($save_code)||empty($save_mobile)){
            throw new ForbiddenHttpException('非法访问');
        }

        $modelClass = new CollectingSeventeenFilesText();
        $query = $modelClass::findOne(['cellphone'=>$save_mobile]);
        if(empty($query)){
            $modelClass->cellphone = $save_mobile;
            $modelClass->sex = 0;
            $modelClass->save();
            $query = $modelClass;
        }

        try{
            $img = CollectingSeventeenFilesImg::find()->where(['text_id'=>$query->id,'type'=>0])->asArray()->all();
            $wei_img = CollectingSeventeenFilesImg::find()->where(['text_id'=>$query->id,'type'=>1])->asArray()->all();
        }catch (\Exception $e){
            throw new ForbiddenHttpException('非法访问');
        }

        if(!empty($query)){

            if($query['status']!=0){
                return $this->render('success',['id'=>$save_mobile]);
            }
            return $this->render('index',['queries'=>$query,'img'=>$img,'wei_img'=>$wei_img]);
        }
    }
    public function actionPrivateInformation($id=null){

        if(empty($id)){
            throw new ForbiddenHttpException('非法访问');
        }

        $model = new CollectingSeventeenFilesText();
        $query = $model::find()->where(['flag'=>$id])->asArray()->one();

        try{
            $img = CollectingSeventeenFilesImg::find()->where(['text_id'=>$query['id'],'type'=>1])->asArray()->all();
        }catch (\Exception $e){
            throw new ForbiddenHttpException('非法访问');
        }

        if(!empty($query)){

            if($query['status']==1){
                return $this->render('private-information',['queries'=>$query,'img'=>$img]);
            }if($query['status']==2){
                return $this->render('success',['id'=>$id]);
            }
            return $this->render('index',['queries'=>$query,'img'=>$img]);
        }
    }

    public function actionMessage($id){
        if(empty($id)){
            throw new ForbiddenHttpException('无效链接');
        }
        $model = new CollectingSeventeenFilesText();
        $query = $model::find()->where(['flag'=>$id])->asArray()->one();

        if(!in_array($query['status'],[1,2])){
            throw new ForbiddenHttpException('非法访问');
        }
        try{
            $img = CollectingSeventeenFilesImg::find()->where(['text_id'=>$query['id'],'type'=>0])->asArray()->all();
        }catch (\Exception $e){
            throw new ForbiddenHttpException('非法访问');
        }
        return $this->render('message',['queries'=>$query,'img'=>$img]);

    }

    public function actionText($id){

        $model = $this->findModel($id);

        if($model->status!=0){
            return $this->render('success',['id'=>$model->flag]);
        }

        $postData = $_POST;

        foreach ($postData as $key=>$data){
            $model->$key = $data;
        }

        /*return var_dump($model);
        $model->age = strtotime(Yii::$app->request->post('age'));
        $model->height = Yii::$app->request->post('height');
        $model->weight = Yii::$app->request->post('weight');
        $model->education = Yii::$app->request->post('education');
        $model->cup = Yii::$app->request->post('cup');
        $model->address_detail = Yii::$app->request->post('address_detail');
        $model->address_province = Yii::$app->request->post('address_province');
        $model->address_city = Yii::$app->request->post('address_city');
        $model->job = Yii::$app->request->post('job');
        $model->extra = Yii::$app->request->post('extra');*/

        if($model->update()){
            $model->status = 1;
            $model->update();
            return $this->render('success');
        }else{

            return var_dump($model->errors);
        }

        return $this->redirect('/17-files');
    }
    public function actionPrivateText($id){

        $model = $this->findModel($id);
        if($model->status==0){
            return $this->redirect('/17-files/'.$model->flag);
        }elseif($model->status==2){
            return $this->render('success',['id'=>$model->flag]);
        }
        $model->weichat = Yii::$app->request->post('weichat');
        $model->weibo = Yii::$app->request->post('weibo');
        $model->qq = Yii::$app->request->post('qq');
        $model->id_number = Yii::$app->request->post('id_number');
        $model->cellphone = Yii::$app->request->post('cellphone');
        $model->pay = Yii::$app->request->post('pay');

        if($model->update()){
            $model->status = 2;
            $model->update();
            return $this->render('success',['id'=>$model->flag]);
        }

        return $this->redirect('/17-files/'.$model->flag);
    }

    public function actionSuccess($id){

        return $this->render('success',['id'=>$id]);
    }

    public function actionUploader(){

        $id = Yii::$app->request->post('id');
        $collecting_text = $this->findModel($id);

        if($collecting_text->status==1){
            throw new ForbiddenHttpException('无效链接');
        }

        $data = $collecting_text->upload();

        $html = <<<defo
        <img src=$data[path] data-id=$data[id] class="preview collecting-files-img">
defo;

        echo $html;

    }

    public function actionUploadw(){

        $id = Yii::$app->request->post('wid');
        $collecting_text = $this->findModel($id);

        if($collecting_text->status==1){
            throw new ForbiddenHttpException('无效链接');
        }

        $data = $collecting_text->uploadw();

        $html = <<<defo
        <img src=$data[path] data-id=$data[id] class="preview collecting-files-img">
defo;
        echo $html;
    }


    public function actionDelete($id){

        $model = $this->findModelImg($id);
        $model->delete();
        echo $id;

    }
    protected function extend($file_name){
        $extend = pathinfo($file_name);
        $extend = strtolower($extend["extension"]);
        return $extend;
    }

    protected function findModel($id)
    {
        if (($model = CollectingSeventeenFilesText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findModelImg($id)
    {
        if (($model = CollectingSeventeenFilesImg::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}