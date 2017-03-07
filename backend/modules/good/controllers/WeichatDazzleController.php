<?php

namespace backend\modules\good\controllers;

use frontend\modules\test\models\WeichatDazzleImg;
use Yii;
use backend\modules\good\models\WeichatDazzle;
use backend\modules\good\models\WeichatDazzleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeichatDazzleController implements the CRUD actions for WeichatDazzle model.
 */
class WeichatDazzleController extends Controller
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
     * Lists all WeichatDazzle models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WeichatDazzleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeichatDazzle model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'photos'=> $model->imgs,
        ]);
    }

    /**
     * Creates a new WeichatDazzle model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WeichatDazzle();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WeichatDazzle model.
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

    public function actionUpload($id){

        $model = $this->findModel($id);
        if (Yii::$app->request->isPost) {
            $model->upload();
        }
        return $this->render('upload',[
            'model' =>  $this->findModel($id),
        ]);
    }

    /**
     * Deletes an existing WeichatDazzle model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteImg($id){

        $model = WeichatDazzleImg::findOne(['id' =>  $id]);

        //删除服务器上的图片
        $path = explode(Yii::$app->request->hostInfo,$model['path']);
        $thumb = explode(Yii::$app->request->hostInfo,$model['thumb']);
        if(count($path)<2){
            $path = explode(Yii::$app->params['hostname'],$model['path']);
            $thumb = explode(Yii::$app->params['hostname'],$model['thumb']);
            $path = Yii::getAlias('@frontend/web').$path[1];
            $thumb = Yii::getAlias('@frontend/web').$thumb[1];
        }else{
            $path = Yii::getAlias('@backend/web').$path[1];
            $thumb = Yii::getAlias('@backend/web').$thumb[1];
        }

        if($model->delete()){
            unlink($path);
            unlink($thumb);
            Yii::$app->getSession()->getFlash('success','删除成功');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * Finds the WeichatDazzle model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatDazzle the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatDazzle::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
