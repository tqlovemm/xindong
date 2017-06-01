<?php

namespace backend\modules\dating\controllers;

use api\modules\v9\models\AppSpecialDatingImages;
use Yii;
use backend\modules\dating\models\AppSpecialDatingSearch;
use backend\modules\dating\models\AppSpecialDating;
use backend\modules\sm\models\Province;
use common\Qiniu\QiniuUploader;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

class AppSpecialDatingController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;

    public function actionIndex()
    {
        $searchModel = new AppSpecialDatingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',['dataProvider'=>$dataProvider,'searchModel'=>$searchModel]);
    }

    public function actionCreate(){

        $model = new AppSpecialDating();
        $province = ArrayHelper::map(Province::find()->asArray()->all(),'prov_name','prov_name');
        if ($model->load(Yii::$app->request->post())) {
            if ($model->validate()) {
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->zid]);
                }
            }
        }
        return $this->render('create', [
            'model' => $model,'province'=>$province
        ]);

    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $province = ArrayHelper::map(Province::find()->asArray()->all(),'prov_name','prov_name');
        if ($model->load(Yii::$app->request->post())) {
            if($model->update()){
                return $this->redirect(['view', 'id' => $model->zid]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,'province'=>$province
            ]);
        }
    }

    public function actionUpload($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $model->upload();
        }
        return $this->render('upload', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionUploadw($id)
    {
        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $model->uploadw();
        }
        return $this->render('upload', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
            return $this->redirect('index');
        }
        return var_dump($model->errors);

    }
    public function actionDeleteWeima($id)
    {
        $model = $this->findModel($id);
        $weima = $model->weima;
        $model->weima = "";

        if($model->update()){
            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $qn->delete('test02',$weima);
            return $this->redirect(Yii::$app->request->referrer);
        }
        return var_dump($model->errors);

    }
    public function actionDeleteImage($id)
    {
        $model = AppSpecialDatingImages::findOne($id);
        $type = $model->type;

        if($model->delete()){
            if($type == 1){
                $imgModel = AppSpecialDatingImages::findOne(['zid'=>$model->zid]);
                if(!empty($imgModel)){
                    $imgModel->type = 1;
                    $imgModel->update();
                }
            }
            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $qn->delete('test02',$model->img_path);
            return $this->redirect(Yii::$app->request->referrer);
        }
    }


    public function actionSetCoverPhoto($id){

        $model = AppSpecialDatingImages::findOne($id);
        if($model->type==1){
            return $this->redirect(Yii::$app->request->referrer);
        }else{
            AppSpecialDatingImages::updateAll(['type'=>0],['zid'=>$model->zid]);
            $model->type = 1;
            if($model->update()){
                return $this->redirect(Yii::$app->request->referrer);
            }else{
                var_dump($model->errors);
            }
        }
    }

    protected function findModel($id)
    {
        if (($model = AppSpecialDating::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }


}
