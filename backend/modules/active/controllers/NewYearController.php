<?php

namespace backend\modules\active\controllers;

use frontend\modules\test\models\NewYearImg;
use Yii;
use backend\modules\active\models\NewYear;
use backend\modules\active\models\NewYearSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\components\MyUpload;
use yii\myhelper\WaterMark;

/**
 * NewYearController implements the CRUD actions for NewYear model.
 */
class NewYearController extends Controller
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
     * Lists all NewYear models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new NewYearSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single NewYear model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $photo = NewYearImg::find()->where(['da_id'=>$id])->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'photos'  =>  $photo,
        ]);
    }

    /**
     * Creates a new NewYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new NewYear();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpload($id){

        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {

            $this->upload($id);
        }
        return $this->render('upload',[
            'model' =>  $this->findModel($id),
        ]);
    }

    public function upload($id){

        $config = [
            'savePath'   => Yii::getAlias('@frontend/web/uploads/newy'),
            'maxSize'    => 5000,
            'allowFiles' => ['.jpg','.jpeg','.png','.bmp']
        ];

        $up = new MyUpload("file",$config,"",true);

        $info = $up->getFileInfo();
        //添加水印;
        $mark = new WaterMark();
        $mark->ImgMark($config['savePath'].'/'.$info['name'],$config['savePath'].'/'.$info['name'],'http://13loveme.com/images/watermark/3333.png');
        $mark->imgMark($config['savePath'].'/thumb/'.$info['name'],$config['savePath'].'/thumb/'.$info['name'],'http://13loveme.com/images/watermark/3333.png');

        $img = new NewYearImg();
        $img->da_id         = $id;
        $img->created_at    = time();
        $img->updated_at    = time();
        $img->path          = 'http://13loveme.com/uploads/newy/'.$info['name'];
        $img->thumb         = 'http://13loveme.com/uploads/newy/thumb/'.$info['name'];
        $img->save();
    }

    /**
     * Updates an existing NewYear model.
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
     * Deletes an existing NewYear model.
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
     * Finds the NewYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return NewYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = NewYear::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
