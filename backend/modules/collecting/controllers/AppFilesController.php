<?php

namespace backend\modules\collecting\controllers;

use backend\modules\collecting\models\AppFiles;
use backend\modules\collecting\models\AppFilesImg;
use backend\modules\flop\models\FlopContent;
use Yii;
use backend\modules\collecting\models\AppFilesSearch;
use yii\base\Exception;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AppFilesController implements the CRUD actions for AppFiles model.
 */
class AppFilesController extends Controller
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
     * Lists all AppFiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHaveNoFile(){
        $model = new AppFiles();

        $model = $model::find()->select('id')->asArray()->all();
        $query = (new Query())->select('number')->from('pre_flop_content')->where(['is_cover'=>1])->all();
        $data_1 = ArrayHelper::map($model,'id','id');
        $data_2 = ArrayHelper::map($query,'number','number');

        $data = array_intersect($data_1,$data_2);

        $diff = array_diff($data_1,$data);

        return $this->render('no-files',['diff'=>$diff]);

    }

    /**
     * Displays a single AppFiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $img = AppFilesImg::find()->where(['text_id'=>$id])->asArray()->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'img'=>$img,
        ]);
    }

    /**
     * Creates a new AppFiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppFiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AppFiles model.
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
     * Deletes an existing AppFiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }
    public function actionDeleteImg($id)
    {
        AppFilesImg::findOne($id)->delete();

        $url = Yii::$app->request->referrer;
        return $this->redirect($url);
    }

    public function actionPass($id){

        $model = $this->findModel($id);
        $model->status = 2;
        if($model->update()){

            try{

                $flop = FlopContent::findOne(['number'=>$id]);
                if(!empty($flop)){
                    $flop->delete();
                }

            }catch (Exception $e){

                throw new Exception($e);
            }


            $insert_flop = new FlopContent();
            $insert_flop->area = $model->address;
            $insert_flop->flop_id = $model->flop_id;
            $insert_flop->created_at = time();
            $insert_flop->created_by = 10000;
            $insert_flop->number = $id;
            $insert_flop->is_cover = 1;
            $insert_flop->content = $insert_flop->path = "http://13loveme.com".$model->getCover();

            if($insert_flop->save()){

                return $this->redirect('index');
            }else{

                return var_dump($insert_flop->errors);
            }
        }else{
            return var_dump($model->errors);
        }
    }
    public function actionNoPass($id){

        $model = $this->findModel($id);
        $model->status = 3;
        if($model->update()){

            return $this->redirect(['index']);
        }else{

            return var_dump($model->errors);
        }
    }

    /**
     * Finds the ThirthFiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppFiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppFiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
