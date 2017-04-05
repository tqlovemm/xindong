<?php

namespace backend\modules\app\controllers;

use Yii;
use backend\modules\app\models\AppOrderList;
use backend\modules\app\models\AppOrderListSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppOrderController implements the CRUD actions for AppOrderList model.
 */
class AppOrderController extends Controller
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
     * Lists all AppOrderList models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppOrderListSearch();
        $data['sort'] = '-updated_at';
        $dataProvider = $searchModel->search($data);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionStatic(){

        $model_1 = AppOrderList::find()->select('count(*) as n,sum(total_fee) as t,type,max(updated_at) as max,min(updated_at) as min')->groupBy('type')->orderBy('updated_at desc')->asArray()->all();
        $model_2 = AppOrderList::find()->select('count(*) as n,sum(total_fee) as t,week_time as w,max(updated_at) as max,min(updated_at) as min')->groupBy('week_time')->orderBy('week_time desc')->asArray()->all();
        $model_3 = AppOrderList::find()->select('count(*) as n,sum(total_fee) as t,month_time as w,max(updated_at) as max,min(updated_at) as min')->groupBy('month_time')->orderBy('month_time desc')->asArray()->all();
        $model_4 = AppOrderList::find()->select('count(*) as n,sum(total_fee) as t,max(updated_at) as max,min(updated_at) as min')->asArray()->all();
        $model_5 = AppOrderList::find()->select('count(*) as n,sum(total_fee) as t,max(updated_at) as max,min(updated_at) as min,channel')->groupBy('channel')->asArray()->all();
        $model_6 = AppOrderList::find()->select('count(*) as n,sum(total_fee) as t,created_at as c')->groupBy('created_at')->orderBy('created_at desc')->asArray()->all();
        return $this->render('static',['model_1'=>$model_1,'model_2'=>$model_2,'model_3'=>$model_3,'model_4'=>$model_4,'model_5'=>$model_5,'model_6'=>$model_6,]);
    }

    public function actionStatisticalChart(){
        $model = AppOrderList::find()->select('count(*) as n,sum(total_fee) as t,created_at as c')->groupBy('created_at')->asArray()->all();
        return $this->render('statistical-chart',['model'=>$model]);
    }
    /**
     * Displays a single AppOrderList model.
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
     * Creates a new AppOrderList model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppOrderList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AppOrderList model.
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
     * Deletes an existing AppOrderList model.
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
     * Finds the AppOrderList model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppOrderList the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppOrderList::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
