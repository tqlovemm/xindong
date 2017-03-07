<?php

namespace frontend\modules\member\controllers;

use backend\modules\setting\models\AuthAssignment;
use Yii;
use frontend\modules\member\models\EnterTheBackground;
use frontend\modules\member\models\EnterTheBackgroundSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EnterTheBackgroundController implements the CRUD actions for EnterTheBackground model.
 */
class EnterBackgroundController extends Controller
{
    public $layout = '@app/themes/basic/layouts/main';
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','view','create','update','delete'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            $model = new AuthAssignment();
                            $user_id = Yii::$app->user->id;
                            if(in_array($user_id,$model::find()->select('user_id')->column())){
                                return true;
                            }
                        }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }


    /**
     * Lists all EnterTheBackground models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EnterTheBackgroundSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single EnterTheBackground model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        if($model->created_by==Yii::$app->user->identity->username){
            return $this->render('view', [
                'model' => $this->findModel($id),
            ]);
        }else{

            throw new ForbiddenHttpException('非法访问');
        }

    }

    /**
     * Creates a new EnterTheBackground model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new EnterTheBackground();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing EnterTheBackground model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if(Yii::$app->user->id==10000){
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else{
            throw new ForbiddenHttpException('非法操作');
        }
    }

    /**
     * Deletes an existing EnterTheBackground model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->id==10000){
            $this->findModel($id)->delete();
        }else{
            throw new ForbiddenHttpException('非法操作');
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the EnterTheBackground model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return EnterTheBackground the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = EnterTheBackground::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
