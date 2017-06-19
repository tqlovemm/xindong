<?php

namespace backend\modules\article\controllers;

use Yii;
use backend\modules\article\models\ArticleAdver;
use backend\modules\article\models\ArticleAdverSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\Qiniu\QiniuUploader;

/**
 * ArticleAdverController implements the CRUD actions for ArticleAdver model.
 */
class ArticleAdverController extends Controller
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
     * Lists all ArticleAdver models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleAdverSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticleAdver model.
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
     * Creates a new ArticleAdver model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleAdver();

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['thumb']['name']){
                $qn = new QiniuUploader('thumb',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
                $path = 'uploads/qinhua/';
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid().substr($_FILES['wimg']['name'], strrpos($_FILES['wimg']['name'], '.'));
                $qiniu = $qn->upload_app('appimages',$path.$mkdir,$_FILES['thumb']['tmp_name']);
                $wimg =  Yii::$app->params['appimages'].$qiniu['key'];
                $model->thumb = $wimg;
            }
            if($model->save()){
                return $this->redirect(['index']);
            }else{
                return "添加失败";
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ArticleAdver model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['thumb']['name']){
                $qn = new QiniuUploader('thumb',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
                $path = 'uploads/qinhua/';
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid().substr($_FILES['wimg']['name'], strrpos($_FILES['wimg']['name'], '.'));
                $qiniu = $qn->upload_app('appimages',$path.$mkdir,$_FILES['thumb']['tmp_name']);
                $wimg =  Yii::$app->params['appimages'].$qiniu['key'];
                $model->thumb = $wimg;
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return "添加失败";
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ArticleAdver model.
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
     * Finds the ArticleAdver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleAdver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleAdver::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
