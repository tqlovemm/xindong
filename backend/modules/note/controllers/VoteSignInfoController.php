<?php

namespace backend\modules\note\controllers;

use backend\modules\note\models\VoteSignImg;
use common\Qiniu\QiniuUploader;
use Yii;
use backend\modules\note\models\VoteSignInfo;
use backend\modules\note\models\VoteSignInfoSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VoteSignInfoController implements the CRUD actions for VoteSignInfo model.
 */
class VoteSignInfoController extends Controller
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
     * Lists all VoteSignInfo models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new VoteSignInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single VoteSignInfo model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $img = $model->voteSignImgs;
        return $this->render('view', [
            'model' => $model,'img'=>$img,
        ]);
    }

    /**
     * Creates a new VoteSignInfo model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new VoteSignInfo();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
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
     * Updates an existing VoteSignInfo model.
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
     * Deletes an existing VoteSignInfo model.
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
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDeleteImg($id){

        $model = VoteSignImg::findOne($id);
        $url = Yii::$app->request->referrer;
        if($model->delete()){
            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $qn->delete('vote',$model->img);
            return $this->redirect($url);
        }

    }

    /**
     * @param $id
     * @return \yii\web\Response
     */

    public function actionPass($id){

        $url = Yii::$app->request->referrer;
        $model = $this->findModel($id);
        $model->status = 2;
        $model->extra = Null;
        if($model->update()){
            return $this->redirect($url);
        }
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */

    public function actionNoPass($id, $extra){

        $url = Yii::$app->request->referrer;
        $model = $this->findModel($id);
        $model->status = 3;
        $model->extra = $extra;
        if($model->update()){
            return $this->redirect($url);
        }

    }

    /**
     * Finds the VoteSignInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return VoteSignInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = VoteSignInfo::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
