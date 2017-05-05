<?php

namespace backend\modules\male\controllers;

use common\Qiniu\QiniuUploader;
use frontend\modules\male\models\MaleInfoImages;
use Yii;
use frontend\modules\male\models\MaleInfoText;
use backend\modules\male\models\MaleInfoTextSearch;
use yii\data\Pagination;
use yii\myhelper\Mobile;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MaleInfoTextController implements the CRUD actions for MaleInfoText model.
 */
class MaleInfoTextController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all MaleInfoText models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MaleInfoTextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionNoPass($id){

        $model = $this->findModel($id);
        $model->no_pass_reason = $_POST['no_pass_reason'];
        $model->status = $_POST['status'];
        if($model->update()){
            return $this->redirect(['view','id'=>$id]);
        }
    }

    public function actionPass($id){

        $model = $this->findModel($id);
        $model->status = 2;
        $model->update();
    }

    public function actionSetAvatar($id){

        $model = MaleInfoImages::findOne($id);
        if($model->type!=1){
            if(($ext = MaleInfoImages::findOne(['text_id'=>$model->text_id,'type'=>1]))!=null){
                $ext->type = 0;
                $ext->update();
            }
            $model->type = 1;
            if($model->update()){
                $url = Yii::$app->request->referrer;
                return $this->redirect($url);
            }
        }else{
            $url = Yii::$app->request->referrer;
            return $this->redirect($url);
        }

    }

    public function actionDeleteImg($id){
        $model = MaleInfoImages::findOne($id);
        $_model = $model;
        if($model->delete()){
            $qn = new QiniuUploader('weimaimg',\Yii::$app->params['qnak1'],\Yii::$app->params['qnsk1']);
            $qn->delete('test02',$model->img);
        }

        if($_model->type==1){
            $setAvatarModel = MaleInfoImages::findOne(['text_id'=>$model->text_id,'type'=>0]);
            if(!empty($setAvatarModel)){
                $setAvatarModel->type = 1;
                $setAvatarModel->update();
            }
        }

        $url = Yii::$app->request->referrer;
        return $this->redirect($url);
    }

    public function actionImageIndex(){

        $data = MaleInfoText::find();
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('image-index',[
           'model' => $model,
           'pages' => $pages,
        ]);

    }

    /**
     * Displays a single MaleInfoText model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MaleInfoText model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MaleInfoText();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MaleInfoText model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MaleInfoText model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the MaleInfoText model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MaleInfoText the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MaleInfoText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
