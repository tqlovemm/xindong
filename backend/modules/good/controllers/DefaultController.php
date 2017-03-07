<?php

namespace backend\modules\good\controllers;

use backend\modules\good\models\AnecdoteThreads;
use Yii;
use backend\modules\good\models\AnecdoteThreadsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DefaultController implements the CRUD actions for AnecdoteThreads model.
 */
class DefaultController extends Controller
{
    public $enableCsrfValidation=false;
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
     * Lists all AnecdoteThreads models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AnecdoteThreadsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AnecdoteThreads model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }
    public function actionCheckPass($id){


        $model = AnecdoteThreads::findOne($id);

        $model->status = 4;
        $model->update();

        return $this->redirect(Yii::$app->request->referrer);


    }

    public function actionUpload($id){

        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {

            echo $model->upload();
        }

        return $this->render('upload',['model'=>$this->findModel($id)]);
    }

    /**
     * Creates a new AnecdoteThreads model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AnecdoteThreads();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AnecdoteThreads model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->tid]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AnecdoteThreads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $imgs = $model['img'];
        $frontroot = Yii::getAlias('@frontend/web');
        foreach($imgs as $list){
            $imgPath1 = $list['img'];
            $thumbpath1 = $list['thumbimg'];

            if(file_exists($frontroot.$imgPath1)){
                unlink($frontroot.$imgPath1);
                unlink($frontroot.$thumbpath1);
            }
        }

        $model->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the AnecdoteThreads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AnecdoteThreads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AnecdoteThreads::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
