<?php

namespace backend\modules\sm\controllers;

use backend\modules\sm\models\SmCollectionFilesImg;
use Yii;
use backend\modules\sm\models\SmCollectionFilesText;
use backend\modules\sm\models\SmCollectionFilesTextSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SmCollectionFilesTextController implements the CRUD actions for SmCollectionFilesText model.
 */
class SmCollectionFilesTextController extends Controller
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
     * Lists all SmCollectionFilesText models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SmCollectionFilesTextSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDeleteImg($id)
    {
        $model = SmCollectionFilesImg::findOne($id);
        $model->delete();
        $url = Yii::$app->request->referrer;
        return $this->redirect($url);
    }

    /**
     * Displays a single SmCollectionFilesText model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = SmCollectionFilesText::find()->where(['member_id'=>$id])->with('img')->asArray()->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new SmCollectionFilesText model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SmCollectionFilesText();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->member_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SmCollectionFilesText model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->member_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SmCollectionFilesText model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SmCollectionFilesText model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return SmCollectionFilesText the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SmCollectionFilesText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
