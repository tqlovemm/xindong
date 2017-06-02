<?php

namespace backend\modules\article\controllers;

use Yii;
use backend\modules\article\models\ArticleLabel;
use backend\modules\article\models\ArticleLabelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\Qiniu\QiniuUploader;

/**
 * ArticleLabelController implements the CRUD actions for ArticleLabel model.
 */
class ArticleLabelController extends Controller
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
     * Lists all ArticleLabel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ArticleLabelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ArticleLabel model.
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
     * Creates a new ArticleLabel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ArticleLabel();

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['thumb']['name']){
                $qn = new QiniuUploader('thumb',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid();
                $qiniu = $qn->upload_water('appimages',"uploads/qinhua/$mkdir");
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
     * Updates an existing ArticleLabel model.
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
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid();
                $qiniu = $qn->upload_water('appimages',"uploads/qinhua/$mkdir");
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
     * Deletes an existing ArticleLabel model.
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
     * Finds the ArticleLabel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ArticleLabel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ArticleLabel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
