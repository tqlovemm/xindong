<?php

namespace backend\modules\exciting\controllers;

use Yii;
use backend\modules\exciting\models\WebsiteContent;
use backend\modules\exciting\models\WebsiteContentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
/**
 * WebsiteContentSearchController implements the CRUD actions for WebsiteContent model.
 */
class WebsiteContentSearchController extends Controller
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

    public function actionIndex()
    {
        $searchModel = new WebsiteContentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new WebsiteContent();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arr = [0=>'午夜00点',1=>'凌晨1点',2=>'凌晨2点',3=>'凌晨3点',4=>'凌晨4点',5=>'凌晨5点',6=>'早上6点',
            7=>'早上7点',8=>'早上8点',9=>'上午9点',10=>'上午10点',11=>'上午11点',12=>'中午12点',13=>'下午1点',14=>'下午2点',15=>'下午3点',16=>'下午4点',17=>'下午5点',18=>'下午6点',19=>'下午7点',20=>'下午8点',
            21=>'晚上9点',22=>'晚上10点',23=>'晚上11点',
        ];
        $end_time = $arr;
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->cid]);
        } else {
            return $this->render('update', [
                'model' => $model,'arr'=>$arr,'end_time'=>$end_time
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect('/index.php/exciting/website');
    }

    public function actionLists($id){
        $arr = [0=>'午夜00点',1=>'凌晨1点',2=>'凌晨2点',3=>'凌晨3点',4=>'凌晨4点',5=>'凌晨5点',6=>'早上6点',
            7=>'早上7点',8=>'早上8点',9=>'上午9点',10=>'上午10点',11=>'上午11点',12=>'中午12点',13=>'下午1点',14=>'下午2点',15=>'下午3点',16=>'下午4点',17=>'下午5点',18=>'下午6点',19=>'下午7点',20=>'下午8点',
            21=>'晚上9点',22=>'晚上10点',23=>'晚上11点',24=>'午夜12点',
        ];

        if(!is_numeric($id)){
            echo "";return;
        }
        for ($i=$id;$i>=0;$i--){
            unset($arr[$i]);
        }

        foreach ($arr as $key=>$branche) {
            echo "<option value='" . $key . "'>" . $branche . "</option>";
        }

    }
    protected function findModel($id)
    {
        if (($model = WebsiteContent::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
