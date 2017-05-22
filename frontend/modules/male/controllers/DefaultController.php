<?php

namespace frontend\modules\male\controllers;

use Yii;
use common\Qiniu\QiniuUploader;
use frontend\modules\male\models\MaleInfoImages;
use frontend\modules\male\models\MaleInfoText;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class DefaultController extends Controller
{
    public function actionIndex($flag)
    {
        $model = $this->findModel($flag);

        if($model->status==0){
            if ($model->load(Yii::$app->request->post())) {
                if ($model->validate()) {
                    $model->update();
                }
            }
            return $this->render('index', [
                'model' => $model,
            ]);
        }/*elseif($model->status==1){
            return $this->render('index', [
                'model' => $model,
            ]);
        }*/else{
            return $this->redirect(['register-type','flag'=>$flag]);
        }
    }
    public function actionSave($id,$data,$fileID){

        $data = json_decode($data,true);
        $model = new MaleInfoImages();
        if(empty($model::findOne(['text_id'=>$id,'type'=>1]))){
            $model->type = 1;
        }else{
            $model->type = 0;
        }
        $model->text_id = $id;
        $model->clent_id = $fileID;
        $model->img = $data['key'];
        if($model->save()){
            echo json_encode($model->id);
        }else{
            echo json_encode($model->errors);
        }
    }
    public function actionSaveWeima($id,$data,$fileID){

        $data = json_decode($data,true);
        $model = new MaleInfoImages();
        if(empty($model::findOne(['text_id'=>$id,'type'=>2]))){
            $model->text_id = $id;
            $model->clent_id = $fileID;
            $model->img = $data['key'];
            $model->type = 2;
            $model->save();
        }else{
            echo "<script>alert('已存在二维码')</script>";
        }

    }

    public function actionUpToken(){
        $qn = new QiniuUploader('weimaimg',\Yii::$app->params['qnak1'],\Yii::$app->params['qnsk1']);
        $uptoken = array('uptoken'=>$qn->upToken('test02'));
        return json_encode($uptoken);

    }

    public function actionRegisterType(){

        return $this->render('register-type');
    }

    public function actionDeleteImg($id){

        $model = MaleInfoImages::findOne(['clent_id'=>$id]);
        $qn = new QiniuUploader('weimaimg',\Yii::$app->params['qnak1'],\Yii::$app->params['qnsk1']);
        $qn->delete('test02',$model->img);
        echo $model->delete();
    }
    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = MaleInfoText::findOne(['flag'=>$id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
