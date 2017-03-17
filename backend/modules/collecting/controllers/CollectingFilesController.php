<?php

namespace backend\modules\collecting\controllers;

use backend\components\AddRecord;
use frontend\models\CollectingSeventeenFilesImg;
use Yii;
use backend\models\CollectingFilesText;
use backend\modules\collecting\models\CollectingFilesSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * Collecting17FilesController implements the CRUD actions for Collecting17FilesText model.
 */
class CollectingFilesController extends Controller
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
     * Lists all Collecting17FilesText models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CollectingFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Collecting17FilesText model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $img = CollectingSeventeenFilesImg::find()->where(['text_id'=>$id])->asArray()->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'img'=>$img,
        ]);
    }

    /**
     * Creates a new Collecting17FilesText model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CollectingFilesText();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Collecting17FilesText model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            if($model->update()){

                $data_arr = array('description'=>"修改十七平台女会员的信息，女生会员ID：{$id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Collecting17FilesText model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){
            $data_arr = array('description'=>"删除十七平台女会员的信息，女生会员ID：{$id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }
        return $this->redirect(['index']);
    }

    public function actionDeleteImg($id)
    {
        $model = CollectingSeventeenFilesImg::findOne($id);
        if($model->delete())
        {
            $data_arr = array('description'=>"删除十七平台女会员的一张图片，女生会员ID：{$model->text_id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
            Yii::$app->getSession()->setFlash('success','删除成功');
        }

        return $this->redirect(Yii::$app->request->referrer);
    }

    /**
     * @param $id
     * @return null|static
     * @throws NotFoundHttpException
     */
    protected function findModel($id)
    {
        if (($model = CollectingFilesText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
