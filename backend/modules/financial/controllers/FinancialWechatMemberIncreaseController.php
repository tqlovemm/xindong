<?php

namespace backend\modules\financial\controllers;

use backend\modules\financial\models\FinancialWechat;
use Yii;
use backend\modules\financial\models\FinancialWechatMemberIncrease;
use backend\modules\financial\models\FinancialWechatMemberIncreaseSearch;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinancialWechatMemberIncreaseController implements the CRUD actions for FinancialWechatMemberIncrease model.
 */
class FinancialWechatMemberIncreaseController extends Controller
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
     * Lists all FinancialWechatMemberIncrease models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinancialWechatMemberIncreaseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinancialWechatMemberIncrease model.
     * @param integer $id
     * @param integer $wechat_id
     * @return mixed
     */
    public function actionView($id, $wechat_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $wechat_id),
        ]);
    }

    /**
     * Creates a new FinancialWechatMemberIncrease model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($wechat_id)
    {
        $model = new FinancialWechatMemberIncrease();
        $model->wechat_id = $wechat_id;
        $query = FinancialWechatMemberIncrease::find()->select('total_count')->where(['wechat_id'=>$wechat_id])->orderBy('created_at desc')->asArray()->one();
        if ($model->load(Yii::$app->request->post())&& $model->validate()) {
            $model->wechat_loose_change_screenshot = $model->upload();
            if($model->save()){
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('create', [
                'model' => $model,'total_count'=>$query['total_count'],
            ]);
        }
    }

    /**
     * Updates an existing FinancialWechatMemberIncrease model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $wechat_id
     * @return mixed
     */
    public function actionUpdate($id, $wechat_id)
    {
        $model = $this->findModel($id, $wechat_id);
        $wechat = ArrayHelper::map(FinancialWechat::findAll(['status'=>10]),'id','wechat');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'wechat_id' => $model->wechat_id]);
        } else {
            return $this->render('update', [
                'model' => $model,'wechat'=>$wechat
            ]);
        }
    }

    /**
     * Deletes an existing FinancialWechatMemberIncrease model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $wechat_id
     * @return mixed
     */
    public function actionDelete($id, $wechat_id)
    {
        $this->findModel($id, $wechat_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FinancialWechatMemberIncrease model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $wechat_id
     * @return FinancialWechatMemberIncrease the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $wechat_id)
    {
        if (($model = FinancialWechatMemberIncrease::findOne(['id' => $id, 'wechat_id' => $wechat_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
