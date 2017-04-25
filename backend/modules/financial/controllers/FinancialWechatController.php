<?php

namespace backend\modules\financial\controllers;

use backend\modules\financial\models\FinancialWechatJoinRecord;
use backend\modules\financial\models\FinancialWechatMemberIncrease;
use Yii;
use backend\modules\financial\models\FinancialWechat;
use backend\modules\financial\models\FinancialWechatSearch;
use yii\data\Pagination;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinancialWechatController implements the CRUD actions for FinancialWechat model.
 */
class FinancialWechatController extends Controller
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
     * Lists all FinancialWechat models.
     * @return mixed
     */
    public function actionIndex()
    {

        $searchModel = new FinancialWechatSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinancialWechat model.
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
     * @return string
     */
    public function actionTodayJoinRecord(){

        $model = FinancialWechatMemberIncrease::find()->joinWith('wechat')->where(['day_time' => strtotime('yesterday')])->asArray()->all();
        return $this->render('today-join-record',['model'=>$model]);
    }

    /**
     * @param $wechat_id
     * @return string
     */
    public function actionPastJoinRecord($wechat_id){

        $model = FinancialWechatMemberIncrease::find()->where(['wechat_id' => $wechat_id])->orderBy('day_time desc')->asArray()->all();
        $total = FinancialWechatMemberIncrease::find()->addSelect('sum(increase_boy_count) as tc,max(total_count) as mc,sum(join_count) as jc,min(day_time) as dt_min,max(day_time) as dt_max')->where(['wechat_id' => $wechat_id])->asArray()->one();
        return $this->render('past-join-record',['model'=>$model,'total'=>$total]);
    }

    /**
     * @param null $time
     * @param null $wechat_id
     * @return string
     */

    public function actionDayFeeRecord($time = null,$wechat_id = null){

        if($time==null){
            $model = FinancialWechatJoinRecord::find()->joinWith('wechat')->where(['day_time' => strtotime('today')])->asArray()->all();
            return $this->render('today-fee-record',['model'=>$model]);
        }else{
            $model = FinancialWechatJoinRecord::find()->joinWith('wechat')->where(['day_time' => $time,'wechat_id'=>$wechat_id,'type'=>1])->orderBy('created_at desc')->asArray()->all();
            return $this->render('day-fee-record',['model'=>$model]);
        }
    }

    /**
     * @param null $week
     * @param null $mouth
     * @return string
     */
    public function actionEverydayFeeRecord($week=null,$mouth = null){

        $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['day_time'=>strtotime('today')])->asArray()->all();

        if($week!=null){
            $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['weekly_time'=>$week])->asArray()->all();
        }

        if($mouth!=null){
            $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['mouth_time'=>$mouth])->asArray()->all();
        }

        return $this->render('today-fee-record',['model'=>$model]);
    }


    /**
     * @param null $type
     * @return string
     */
    public function actionChoiceMouth($type=null){

        $model = FinancialWechatJoinRecord::find()->select('mouth_time')->groupBy('mouth_time')->orderBy('mouth_time desc')->asArray()->all();
        return $this->render('choice-mouth',['model'=>$model,'type'=>$type]);
    }

    /**
     * @param null $mouth
     * @return string
     */
    public function actionChoiceWeek($mouth=null){

        $model = FinancialWechatJoinRecord::find()->select('weekly_time')->groupBy('weekly_time')->orderBy('weekly_time desc')->where(['mouth_time'=>$mouth])->asArray()->all();
        return $this->render('choice-week',['model'=>$model]);

    }

    /**
     * @return string
     */
    public function actionPastFeeRecord(){

        $model = FinancialWechatJoinRecord::find()->joinWith('wechat')->where(['day_time' => strtotime('today')])->asArray()->all();
        //echo "<pre>";
        //return var_dump($model);
        return $this->render('today-fee-record',['model'=>$model]);
    }

    /**
     * Creates a new FinancialWechat model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionWechatExist($wechat){

        if(!empty(FinancialWechat::findOne(['wechat'=>$wechat]))){
            echo 400;
        }
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new FinancialWechat();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinancialWechat model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    /**
     * Deletes an existing FinancialWechat model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionMom(){


    }

    public function actionAn(){


    }
    /**
     * Finds the FinancialWechat model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinancialWechat the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinancialWechat::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
