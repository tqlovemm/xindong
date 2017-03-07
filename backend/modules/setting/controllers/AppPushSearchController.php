<?php

namespace backend\modules\setting\controllers;

use Yii;
use backend\modules\setting\models\AppPush;
use backend\modules\setting\models\AppPushSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
/**
 * AppPushSearchController implements the CRUD actions for AppPush model.
 */
class AppPushSearchController extends Controller
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
     * Lists all AppPush models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppPushSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppPush model.
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
     * Creates a new AppPush model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppPush();


        if ($model->load(Yii::$app->request->post())) {

            if($model->type=='SSCOMM_AD_WEB'){

                $model->extras = array('push_title'=>urlencode($model->title),'push_content'=>$model->msg,'push_webTitle'=>urlencode($model->title),'push_webUrl'=>$model->msg,'push_type'=>$model->type);
                $model->icon = 'http://13loveme.com:82/images/app_push/u=2084298190,2591444308&fm=21&gp=0.png';

            }elseif($model->type=='SSCOMM_NOTICE'){

                $model->extras = array('push_title'=>urlencode($model->title),'push_content'=>urlencode($model->msg),'push_type'=>$model->type);
                $model->icon = 'http://13loveme.com:82/images/app_push/u=2285230243,2436417019&fm=21&gp=0.png';

            }elseif($model->type=='SSCOMM_LOGINOUT'){

                $model->extras = array('push_title'=>urlencode($model->title),'push_content'=>urlencode($model->msg),'push_type'=>$model->type);
                $model->icon = 'http://13loveme.com:82/images/app_push/u=1817874554,3561189142&fm=21&gp=0.png';

            }

            $model->extras = json_encode($model->extras);

            if($model->save()){

                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AppPush model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if($model->type=='SSCOMM_AD_WEB'){

                $model->extras = array('push_title'=>urlencode($model->title),'push_content'=>$model->msg,'push_webTitle'=>urlencode($model->title),'push_webUrl'=>$model->msg,'push_type'=>$model->type);

            }else{

                $model->extras = array('push_title'=>urlencode($model->title),'push_content'=>urlencode($model->msg),'push_type'=>$model->type);

            }

            $model->extras = json_encode($model->extras);


            if($model->save()){

                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AppPush model.
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
     * Finds the AppPush model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppPush the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppPush::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
