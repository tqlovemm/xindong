<?php

namespace backend\modules\article\controllers;

use Yii;
use backend\modules\article\models\article;
use backend\modules\article\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\Qiniu\QiniuUploader;


/**
 * ArticleController implements the CRUD actions for article model.
 */
class ArticleController extends Controller
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
    public function actions()
    {
        return [
            'ueditor' => [
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/uploads/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }


    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
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
        $model = new article();

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['wimg']['name']){
                $qn = new QiniuUploader('wimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid();
                $qiniu = $qn->upload_water('appimages',"uploads/qinhua/$mkdir");
                $wimg =  Yii::$app->params['appimages'].$qiniu['key'];
                $model->wimg = $wimg;
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return "添加失败";
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['wimg']['name']){
                $qn = new QiniuUploader('wimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid();
                $qiniu = $qn->upload_water('appimages',"uploads/qinhua/$mkdir");
                $wimg =  Yii::$app->params['appimages'].$qiniu['key'];
                $model->wimg = $wimg;
            }
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return "添加失败";
            }
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
