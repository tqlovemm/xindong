<?php


namespace backend\modules\note\controllers;

use Yii;
use backend\modules\note\models\Note;
use yii\data\SqlDataProvider;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;


class NoteController extends BaseController
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
            ->createCommand("SELECT count(*) FROM {{%weichat_note}}  WHERE status=1")
            ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT id, cover_id, status,title,content,url FROM {{%weichat_note}} WHERE status=1 order by id desc',
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
        $model = new Note();
        $path = 'http://www.13loveme.com:82/images/hear'.'/'.rand(1,20).'.jpg';
        if ($model->load(Yii::$app->request->post())) {
            $model->url = $path;
            if($model->save()){

                return $this->redirect(['view', 'id' => $model->id]);
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
        $model = $this->findModel($id);

        $model->delete();

        return $this->redirect('index');

    }

    protected function findModel($id)
    {
        if (($model = Note::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');

        }
    }
}
