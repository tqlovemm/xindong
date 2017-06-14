<?php

namespace backend\modules\apps\controllers;

use Yii;
use api\modules\v11\models\FormThreadComments;
use backend\modules\apps\models\FormThreadCommentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FormThreadCommentController implements the CRUD actions for FormThreadComments model.
 */
class FormThreadCommentController extends Controller
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
     * Lists all FormThreadComments models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FormThreadCommentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FormThreadComments model.
     * @param integer $comment_id
     * @param integer $thread_id
     * @return mixed
     */
    public function actionView($comment_id, $thread_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($comment_id, $thread_id),
        ]);
    }

    /**
     * Creates a new FormThreadComments model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FormThreadComments();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'comment_id' => $model->comment_id, 'thread_id' => $model->thread_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FormThreadComments model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $comment_id
     * @param integer $thread_id
     * @return mixed
     */
    public function actionUpdate($comment_id, $thread_id)
    {
        $model = $this->findModel($comment_id, $thread_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'comment_id' => $model->comment_id, 'thread_id' => $model->thread_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FormThreadComments model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $comment_id
     * @param integer $thread_id
     * @return mixed
     */
    public function actionDelete($comment_id, $thread_id)
    {
        $this->findModel($comment_id, $thread_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FormThreadComments model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $comment_id
     * @param integer $thread_id
     * @return FormThreadComments the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($comment_id, $thread_id)
    {
        if (($model = FormThreadComments::findOne(['comment_id' => $comment_id, 'thread_id' => $thread_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
