<?php

namespace backend\modules\dating\controllers;

use Yii;
use backend\modules\dating\models\HeartWeekContent;
use backend\modules\dating\models\HeartWeekContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * HeartWeekContentSearchController implements the CRUD actions for HeartWeekContent model.
 */
class HeartWeekContentSearchController extends Controller
{
    public $enableCsrfValidation = false;
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
     * Lists all HeartWeekContent models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new HeartWeekContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HeartWeekContent model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {

        $query = Yii::$app->db->createCommand("select status from {{%heartweek}} where id=(select album_id from {{%heartweek_content}} where id=$id)")->queryOne();

        return $this->render('view', [
            'model' => $this->findModel($id),
            'query'=>$query['status'],
        ]);
    }

    /**
     * Creates a new HeartWeekContent model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new HeartWeekContent();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing HeartWeekContent model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
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
    public function actionSlide($id){

   //     $model = Yii::$app->db->createCommand("select * from {{%heartweek_slide_content}} where album_id=$id")->queryAll();

        return $this->redirect('/index.php/dating/heart-week-slide-content',['id'=>$id]);

    }

    /**
     * Deletes an existing HeartWeekContent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
    /**
     * Finds the HeartWeekContent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return HeartWeekContent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HeartWeekContent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
