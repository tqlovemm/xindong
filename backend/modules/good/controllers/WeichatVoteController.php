<?php

namespace backend\modules\good\controllers;

use backend\modules\good\models\WeichatVoteImg;
use Yii;
use backend\modules\good\models\WeichatVote;
use backend\modules\good\models\WeichatVoteSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * WeichatVoteController implements the CRUD actions for WeichatVote model.
 */
class WeichatVoteController extends Controller
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
     * Lists all WeichatVote models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new WeichatVoteSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single WeichatVote model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
            'photos'=>$model->imgs,
        ]);
    }

    /**
     * 添加一个删除参赛点赞竞选男女神用户上传的单个图片
    */
    public function actionDeleteImg($id){

        $model = WeichatVoteImg::findOne(['id'=>$id]);
        //删除服务器上的旧图片
        $path = explode(Yii::$app->request->hostInfo,$model->path);
        $thumb = explode(Yii::$app->request->hostInfo,$model->thumb);
        if(count($path)<2){
            $path = explode(Yii::$app->params['hostname'],$model->path);
            $thumb = explode(Yii::$app->params['hostname'],$model->thumb);
            $path = Yii::getAlias('@frontend/web').$path[1];
            $thumb = Yii::getAlias('@frontend/web').$thumb[1];
        }else{
            $path = Yii::getAlias('@backend/web').$path[1];
            $thumb = Yii::getAlias('@backend/web').$thumb[1];
        }

        if($model->delete()){
            unlink($path);
            unlink($thumb);
            Yii::$app->getSession()->setFlash('success','删除成功');
        }
        return $this->redirect(Yii::$app->request->referrer);
    }
    /**
     * Creates a new WeichatVote model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new WeichatVote();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing WeichatVote model.
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
     * Deletes an existing WeichatVote model.
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
     * Finds the WeichatVote model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return WeichatVote the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = WeichatVote::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
