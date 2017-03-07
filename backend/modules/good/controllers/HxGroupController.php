<?php

namespace backend\modules\good\controllers;

use Yii;
use backend\modules\good\models\HxGroup;
use \backend\modules\good\models\HxGroupSearch;
use yii\myhelper\Easemob;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * HxGroupController implements the CRUD actions for HxGroup model.
 */
class HxGroupController extends Controller
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
     * Lists all HxGroup models.
     * @return mixed
     */
    public function actionIndex()
    {
        $modelClass = new HxGroup();
        $model = $modelClass->find()->where([])->all();
        $group_id = array();
        foreach($model as $item){
            $group_id[] = $item['g_id'];
        }
        $info = $this->getEasemob()->getGroupList();
        foreach($info['data'] as $list){

            if(!in_array($list['groupid'],$group_id)){

                $modelClass->g_id = $list['groupid'];
                $modelClass->affiliations = $list['affiliations'];
                $modelClass->groupname = $list['groupname'];
                $modelClass->owner = $list['owner'];
                if($modelClass->validate()){
                    $modelClass->insert();
                }

            }
        }

        $searchModel = new HxGroupSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single HxGroup model.
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
     * Creates a new HxGroup model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        /*$model = new HxGroup();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }*/
        return $this->redirect(['index']);
    }

    /**
     * Updates an existing HxGroup model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        return $this->redirect(['index']);
        /*$model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }*/
    }

    public function actionUpload($id){

        $model = $this->findModel($id);
        if(Yii::$app->request->isPost){
            $model->upload();
        }
        return $this->render('upload',['model'=>$this->findModel($id)]);
    }

    /**
     * Deletes an existing HxGroup model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        /*$this->findModel($id)->delete();

        return $this->redirect(['index']);*/
        return $this->redirect(['index']);/*
        echo "<script>alert('没有该操作')</script>";*/
    }

    /**
     * Finds the HxGroup model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return HxGroup the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = HxGroup::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function getEasemob(){

        $config = [
            'client_id' =>  Yii::$app->params['client_id'],
            'client_secret' =>  Yii::$app->params['client_secret'],
            'org_name' =>  Yii::$app->params['org_name'],
            'app_name' =>  Yii::$app->params['app_name'],
        ];
        $e = new Easemob($config);
        return $e;
    }
}
