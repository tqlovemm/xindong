<?php

namespace frontend\controllers;
use common\Qiniu\QiniuUploader;
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

        if($model->update()){
            $model->status = 1;
            $model->update();
            return $this->render('success');
        }else{

            return var_dump($model->errors);
        }

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
        <img src=$data[path] onclick=deleteImg($data[id]) class="preview collecting-files-img">
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
        <img src=$data[path]  onclick=deleteImg($data[id]) class="preview collecting-files-img">
defo;
        echo $html;
    }


    public function actionDelete($id){

        $model = $this->findModelImg($id);
        $model->delete();
        $qn = new QiniuUploader('files',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qn->delete('shisan',$model->img);
        echo $id;

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