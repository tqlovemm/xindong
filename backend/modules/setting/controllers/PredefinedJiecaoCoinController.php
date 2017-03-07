<?php

namespace backend\modules\setting\controllers;

use backend\components\AddRecord;
use Yii;
use backend\modules\setting\models\PredefinedJiecaoCoin;
use backend\modules\setting\models\PredefinedJiecaoCoinSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PredefinedJiecaoCoinController implements the CRUD actions for PredefinedJiecaoCoin model.
 */
class PredefinedJiecaoCoinController extends Controller
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
     * Lists all PredefinedJiecaoCoin models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PredefinedJiecaoCoinSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PredefinedJiecaoCoin model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new PredefinedJiecaoCoin model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PredefinedJiecaoCoin();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $data = json_encode($model->attributes);
            $data_array = array('description'=>"增加固定节操币充值项目，增加ID为{$model->id}",'data'=>$data,'old_data'=>'','new_data'=>'','type'=>1);
            AddRecord::record($data_array);

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing PredefinedJiecaoCoin model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $old = json_encode($model->attributes);

        if ($model->load(Yii::$app->request->post()) && $model->update()) {

            $new = json_encode($model->oldAttributes);

            $data_array = array('description'=>"更新节操币固定充值金额，订单ID为{$id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
            AddRecord::record($data_array);

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PredefinedJiecaoCoin model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $old = json_encode($model->attributes);
        if($model->delete()){
            $data_array = array('description'=>"删除固定节操币充值，订单ID为{$id}",'data'=>$old,'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_array);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the PredefinedJiecaoCoin model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PredefinedJiecaoCoin the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PredefinedJiecaoCoin::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
