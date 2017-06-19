<?php

namespace backend\modules\apps\controllers;

use api\modules\v11\models\FormThreadImages;
use api\modules\v11\models\FormThreadTag;
use common\Qiniu\QiniuUploader;
use Yii;
use api\modules\v11\models\FormThread;
use backend\modules\apps\models\FormThreadSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FormThreadController implements the CRUD actions for FormThread model.
 */
class FormThreadController extends Controller
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
     * Lists all FormThread models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FormThreadSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FormThread model.
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
     * Creates a new FormThread model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FormThread();
        $tag = ArrayHelper::map(FormThreadTag::find()->select('tag_name')->asArray()->all(),'tag_name','tag_name');
        $model->user_id = Yii::$app->user->id;
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->type !=0){
                $model->sex = 2;
            }

            if($model->save()){
                return $this->redirect(['view', 'id' => $model->wid]);
            }

        } else {
            return $this->render('create', [
                'model' => $model,'tagList'=>$tag
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     */
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
     * Updates an existing FormThread model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $tag = ArrayHelper::map(FormThreadTag::find()->select('tag_name')->asArray()->all(),'tag_name','tag_name');
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if($model->type !=0){
                $model->sex = 2;
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->wid]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,'tagList'=>$tag
            ]);
        }
    }

    /**
     * Deletes an existing FormThread model.
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

        $model = FormThreadImages::findOne($id);

        if($model->delete()){
            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $path = explode('.com/',$model->img_path);
            $qn->delete('appimages',$path[1]);
        }

        return $this->redirect(Yii::$app->request->referrer);

    }

    /**
     * Finds the FormThread model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FormThread the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FormThread::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
