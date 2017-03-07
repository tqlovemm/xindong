<?php

namespace backend\modules\exciting\controllers;

use backend\modules\exciting\models\OtherTextPic;
use Yii;
use yii\data\Pagination;
use yii\data\SqlDataProvider;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\modules\exciting\models\OtherText;

class OtherTextController extends BaseController
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'view', 'upload', 'index','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {


        $count = Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%all_other_text}} WHERE status=1")
            ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT * FROM {{%all_other_text}} WHERE status=1',
            'totalCount' => $count,
            'pagination' => array('pageSize' => 20),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id,$number=null)
    {

        $searchModel = new OtherTextPic();
        if($number!=null){
            $data = $searchModel::find()->where(['tid'=>$id,'number'=>$number])->orderBy('created_at desc')->asArray();
        }else{
            $data = $searchModel::find()->where(['tid'=>$id])->orderBy('created_at desc')->asArray();
        }

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('view',[
            'model' => $model,
            'pages' => $pages,
            'count'=>$data->count(),
        ]);

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

    public function actionCreate()
    {
        $model = new OtherText();

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->tid]);
            }
        }else{
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if($model->update()){
                return $this->redirect(['view', 'id' => $model->tid]);
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
        return $this->redirect('index');
    }

    protected function findModel($id)
    {
        if (($model = OtherText::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
