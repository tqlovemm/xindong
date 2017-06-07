<?php

namespace backend\modules\saveme\controllers;

use Yii;
use backend\modules\saveme\models\Saveme;
use backend\modules\saveme\models\SavemeSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\db\Query;

class SavemeController extends Controller
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
        $searchModel = new SavemeSearch();
        $arr = $searchModel->search(Yii::$app->request->queryParams);
        $bmcount = array();
        for($i=0;$i<count($arr['data']);$i++){
            $bm = (new Query())->select('saveme_id,id')->from('{{%saveme_apply}}')->where(['saveme_id'=>$arr['data'][$i]->id])->count();
            $bmcount[$arr['data'][$i]->id] = $bm;
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $arr['data'],
            'pages' => $arr['page'],
            'bmcount' => $bmcount,
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
        $model = new Saveme();

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
        $res = $this->findModel($id);
        $res->status = 0;
        $res->save();
        return $this->redirect(['index']);
    }
    protected function findModel($id)
    {
        if (($model = Saveme::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
