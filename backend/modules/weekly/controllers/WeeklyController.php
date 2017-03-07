<?php


namespace backend\modules\weekly\controllers;

use Yii;
use backend\modules\weekly\models\Weekly;
use yii\data\SqlDataProvider;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class WeeklyController extends BaseController
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
            ->createCommand("SELECT count(*) FROM {{%weekly}}  WHERE status=0")
            ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT id, cover_id, status,title,content,url FROM {{%weekly}} WHERE created_by = :user_id and status=0',
            'params' => [':user_id' => Yii::$app->user->id],
            'totalCount' => $count,
            'pagination' => array('pageSize' => 20),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);


    }

    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
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


    public function actionCreate()
    {
        $model = new Weekly();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


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


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Weekly::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
