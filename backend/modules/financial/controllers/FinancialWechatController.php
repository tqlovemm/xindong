<?php

namespace backend\modules\financial\controllers;

use backend\modules\financial\models\FinancialWechatJoinRecord;
use backend\modules\financial\models\FinancialWechatMemberIncrease;
use Yii;
use backend\modules\financial\models\FinancialWechat;
use backend\modules\financial\models\FinancialWechatSearch;
use yii\data\Pagination;
use yii\helpers\ArrayHelper;
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

    public function actionChoiceTime(){

        if(!empty(Yii::$app->request->get('start_time'))){
            $start_time = strtotime(Yii::$app->request->get('start_time'));
            $end_time = strtotime(Yii::$app->request->get('end_time'));
        }else{
            $start_time = strtotime(date('Y-m-01'));
            $end_time = strtotime(date('Y-m-d'));
        }
        $model = FinancialWechatJoinRecord::find()->select("platform,sum(payment_amount) as pa,count(platform) as platform_c")->where(['between','created_at',$start_time,$end_time])->groupBy('platform')->asArray()->all();
        return $this->render('choice-time',['model'=>$model,'start_time'=>$start_time,'end_time'=>$end_time]);
    }

    /**
     * @param $date
     * @return string
     * 环比
     */
    public function actionMomAn($date=null){

        if($date==null){
            $date = time();
        }
        $getDate = $this->getData($date);

        $last_start_time = $getDate[2];
        $last_end_time = $getDate[3];

        $this_start_time = $getDate[4];
        $this_end_time = $getDate[5];

        $past_start_time = $getDate[0];
        $past_end_time = $getDate[1];

        $model_this = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','created_at',$this_start_time,$this_end_time])->asArray()->one();
        $model_last = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','created_at',$last_start_time,$last_end_time])->asArray()->one();
        $model_past = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','created_at',$past_start_time,$past_end_time])->asArray()->one();

        $model_1 = ArrayHelper::map(FinancialWechatJoinRecord::find()->orderBy('day_time desc')->asArray()->all(),'day_time','day_time');
        $model_2 = ArrayHelper::map(FinancialWechatJoinRecord::find()->orderBy('mouth_time desc')->asArray()->all(),'mouth_time','mouth_time');

        return $this->render('mom-an',[
            'model_this'=>$model_this,'model_last'=>$model_last,'model_past'=>$model_past,'this_start_time'=>$this_start_time,
            'this_end_time'=>$this_end_time,'last_start_time'=>$last_start_time,'last_end_time'=>$last_end_time,
            'past_start_time'=>$past_start_time,'past_end_time'=>$past_end_time,'model_1'=>$model_1,'model_2'=>$model_2
        ]);
    }


    public function actionD($date){

        $getDate = $this->getData($date);

        $last_start_time = $getDate[2];
        $last_end_time = $getDate[3];

        $this_start_time = $getDate[4];
        $this_end_time = $getDate[5];

        $past_start_time = $getDate[0];
        $past_end_time = $getDate[1];

        $model_this = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','created_at',$this_start_time,$this_end_time])->asArray()->one();
        $model_last = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','created_at',$last_start_time,$last_end_time])->asArray()->one();
        $model_past = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','created_at',$past_start_time,$past_end_time])->asArray()->one();

        $percent01 = ($model_this['sum']==0)?0:round(($model_this['sum']-$model_last['sum'])/$model_this['sum'],4)*100;
        $percent02 = ($model_past['sum']==0)?0:round(($model_past['sum']-$model_past['sum'])/$model_past['sum'],4)*100;

        $time_1 = date('Y年m月d',$last_start_time).'-'.date('d日',$last_end_time);
        $time_2 = date('Y年m月d',$this_start_time).'-'.date('d日',$this_end_time);
        $time_3 = date('Y年m月d',$past_start_time).'-'.date('d日',$past_end_time);

        $html = <<<eof
            <table class="table table-bordered">
            <caption>其他日期统计</caption>
                <tr>
                    <td rowspan="2" style="vertical-align: middle">总收入</td>
                    <td>$time_1</td>
                    <td>$time_2</td>
                    <td>$time_3</td>
                    <td>环比增长</td>
                    <td>同比增长</td>
                </tr>
                <tr><td style="background-color: yellow;">$model_last[sum]</td><td style="background-color: yellow;">$model_this[sum]</td><td style="background-color: yellow;">$model_past[sum]</td><td>$percent01%</td><td>$percent02%</td></tr>
            </table>
eof;
        echo $html;

    }
    function getData($date)
    {
        //上月环比时间
        $last_month_time = mktime(date("G", $date), date("i", $date),
            date("s", $date), date("n", $date), 0, date("Y", $date));
        $last_month_t =  date("t", $last_month_time);  //二月份的天数

        if ($last_month_t < date("j", $date)) {
            $date_3 = strtotime(date("Y/m/t", $last_month_time));
        }else{
            $date_3 = strtotime(date(date("Y/m", $last_month_time) . "/d", $date));
        }

        $date_4 = strtotime(date('Y/m/01',$last_month_time));

        //本月
        $date_5 = strtotime(date('Y/m/01',$date));
        $date_6 = strtotime(date('Y/m/d',$date));

        //去年同比时间
        //不需要判断2月和是否31号
        $date_2 = strtotime((date('Y',$date) - 1) . '/' . date('m',$date) . '/' . date('d',$date));
        $date_1 = strtotime((date('Y',$date) - 1) . '/' . date('m',$date) . '/' . 1);

        $dateArr = array($date_1,$date_2,$date_4,$date_3,$date_5,$date_6);

        return $dateArr;
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
