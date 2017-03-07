<?php

namespace backend\modules\seek\controllers;

use backend\modules\seek\models\ServicePattersAddAnswers;
use backend\modules\seek\models\ServicePattersAnswerThumbsUp;
use backend\modules\seek\models\ServicePattersImg;
use Yii;
use backend\modules\seek\models\ServicePatters;
use backend\modules\seek\models\ServicePattersSearch;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ServicePattersController implements the CRUD actions for ServicePatters model.
 */
class ServicePattersController extends Controller
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
     * Lists all ServicePatters models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ServicePattersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * 上传图片到相册
     * @param integer $id 相册ID
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
     * Displays a single ServicePatters model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,'imgs'=>$model->images,
        ]);
    }

    /**
     * Creates a new ServicePatters model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ServicePatters();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ServicePatters model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            if(in_array(Yii::$app->user->identity->username,['13bb',$model->created_by])){
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->pid]);
                }
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ServicePatters model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(in_array(Yii::$app->user->id,[10000])){

            $this->findModel($id)->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionDeleteImg($pic_id){

        $model = ServicePattersImg::findOne($pic_id);

        if(in_array(Yii::$app->user->id,[10000])){
            $model->delete();
            return $this->redirect(Yii::$app->request->referrer);
        }

    }

    public function actionSearchView($pid){

        $this->layout = '/other';
        $model = $this->findModel($pid);
        return $this->render('search-view',['model'=>$model,'images'=>$model->images,'addAnswer'=>$model->addAnswer]);
    }

    public function actionAnswerCreate(){

        $post_data = Yii::$app->request->post();
        $model = $this->findModel($post_data['pid']);
        if(!empty($model)){
            $addAnswers = new ServicePattersAddAnswers();
            $addAnswers->pid = $post_data['pid'];
            $addAnswers->content = $post_data['search_content'];
            if($addAnswers->save()){
                return $this->redirect(['search-view','pid'=>$post_data['pid']]);
            }else{
                var_dump($addAnswers->errors);
            }
        }else{
            throw new ForbiddenHttpException('非法操作');
        }
    }

    public function actionThumbsUp($pid,$type){

            $thumbsModel = new ServicePattersAnswerThumbsUp();
            if(empty($thumbsModel::findOne(['pid'=>$pid,'created_by'=>Yii::$app->user->id,'type'=>$type]))){

                $thumbsModel->pid = $pid;
                $thumbsModel->type = $type;

                if($thumbsModel->save()){
                    if($type==1){
                        $model = $this->findModel($pid);
                    }else{
                        $model = ServicePattersAddAnswers::findOne($pid);
                    }
                    $model->thumbs_up += 1;
                    $model->update();
                    echo json_encode($model->thumbs_up);exit;

                }

                echo json_encode($thumbsModel->errors);exit;

            }

            echo 0;exit;

    }

    public function actionPutQuestions(){

        $this->layout = '/other';

        $post_data = Yii::$app->request->post();

        if(!empty($post_data)){

            $model = new ServicePatters();
            $model->subject = $post_data['content'];
            $model->status  = 2;
            if($model->save()){
                return $this->redirect(['search-view','pid'=>$model->pid]);
            }

        }

        return $this->render('search-put-question');

    }

    public function actionYourQuestions($type=1){

        $this->layout = '/other';
        $user_id = Yii::$app->user->id;

        if($type==1){

            $model = ServicePatters::find()->where(['user_id'=>$user_id,'status'=>2])->with('addAnswer')->orderBy('chrono desc')->asArray()->all();

        }elseif($type==2){

            $answer = ServicePattersAddAnswers::find()->select('pid')->where(['created_by'=>$user_id])->column();
            $answers = array_filter(array_unique($answer));
            $model = ServicePatters::find()->where(['pid'=>$answers])->with('addAnswer')->orderBy('chrono desc')->asArray()->all();
        }else{

            $model = ServicePatters::find()->where('user_id!='.$user_id)->andWhere(['status'=>2])->with('addAnswer')->orderBy('chrono desc')->asArray()->all();
        }


        return $this->render('your-questions',['model'=>$model]);

    }

    public function actionYourAnswer(){
        $this->layout = '/other';
        $user_id = Yii::$app->user->id;
        $answer = ServicePattersAddAnswers::find()->select('pid')->where(['created_by'=>$user_id])->column();

        $answers = array_filter(array_unique($answer));

        $model = ServicePatters::find()->where(['pid'=>$answers])->with('addAnswer')->orderBy('chrono desc')->asArray()->all();

    }

    /**
     * Finds the ServicePatters model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ServicePatters the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ServicePatters::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
