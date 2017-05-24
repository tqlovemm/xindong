<?php

namespace backend\modules\financial\controllers;

use backend\models\User;
use backend\modules\financial\models\FinancialWechatJoinRecord;
use backend\modules\financial\models\FinancialWechatMemberIncrease;
use backend\modules\financial\models\FinancialWechatPlatform;
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
    public $enableCsrfValidation = false;
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'delete-record' => ['post'],
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

        $times = ArrayHelper::map(FinancialWechatMemberIncrease::find()->orderBy('day_time desc')->asArray()->all(),'day_time','day_time');

        return $this->render('today-join-record',['day_times'=>$times]);
    }

    public function actionTd($day_time){

        $date = date('Y-m-d',$day_time).' 客服微信号人数统计';
        $model = FinancialWechatMemberIncrease::find()->joinWith('wechat')->where(['day_time' => $day_time])->asArray()->all();
        $html = ' <div class="box box-success">
                <div class="box-header with-border">
                        <h3 class="box-title">'.$date.'</h3>
                        <div class="box-tools pull-right"><button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i></button></div>
                </div>
                <div class="box-body">
                        <table class="table table-bordered">
                        <thead>
                                <tr>
                                        <th rowspan="2">微信号名称</th>
                                        <th rowspan="2">今日总人数</th>
                                        <th rowspan="2">今日早晨未通过人数</th>
                                        <th rowspan="2">昨日增加人数</th>
                                        <th rowspan="2">今日删除人数</th>
                                        <th rowspan="2">今日微信号零钱数</th>
                                        <th rowspan="2">今日入会人数</th>
                                        <th rowspan="2">今日入会率</th>
                                        <th rowspan="2">创建人</th>
                                        <th rowspan="2">往日统计</th>
                                        <th rowspan="2">操作</th>
                                </tr>

                        </thead>
                        <tbody>';
        foreach ($model as $item):
                            $wechat = $item['wechat']['wechat'];
                            $percent = ($item['increase_count']==0)?0:round(($item['join_count']/$item['increase_count']),4)*100;
                            $screenshot = '';
                            $user = User::findOne($item['created_by'])->username .' - '.User::findOne($item['created_by'])->nickname;
                            if(!empty($item['wechat_loose_change_screenshot'])){
                                    $imgPath = Yii::$app->params['test'].$item['wechat_loose_change_screenshot'];
                                    $screenshot = "<a href='$imgPath' data-lightbox='s' data-title='s'>零钱截图</a>";
                            }
                            $joinCount = '';
                            if($item['join_count']){
                                    $joinCount = "<a href='day-fee-record?time=$item[day_time]&wechat_id=$item[wechat_id]&wechat=$wechat' target='_blank'>截图</a>";
                            }

                            $html .= "<tr>
                                    <td>$wechat</td>
                                    <td>$item[total_count]</td>
                                    <td>$item[morning_increase_count]</td>
                                    <td>$item[increase_count]</td>
                                    <td>$item[reduce_count]</td>
                                    <td>$item[loose_change] — $screenshot</td>
                                    <td>$item[join_count] $joinCount</td>
                                    <td>$percent%</td>
                                    <td>$user</td>
                                    <td>
                                        <a target='_blank' href='past-join-record?wechat_id=$item[wechat_id]&wechat=$wechat'>查看</a>
                                    </td>
                                    <td>删除</td>
                                    </tr>";
        endforeach;

        $html .= "           </tbody>
                        </table>
                </div>
        </div>";
        echo $html;

    }
    /**
     * @param $wechat_id
     * @return string
     */
    public function actionPastJoinRecord($wechat_id){

        $model = FinancialWechatMemberIncrease::find()->where(['wechat_id' => $wechat_id])->orderBy('day_time desc')->asArray()->all();
        $total = FinancialWechatMemberIncrease::find()->addSelect('sum(increase_count) as tc,max(total_count) as mc,sum(join_count) as jc,min(day_time) as dt_min,max(day_time) as dt_max')->where(['wechat_id' => $wechat_id])->asArray()->one();
        return $this->render('past-join-record',['model'=>$model,'total'=>$total]);
    }

    /**
     * @param null $time
     * @param null $wechat_id
     * @return string
     */

    public function actionDayFeeRecord($time = null,$wechat_id = null){

        if($time==null){
            $model = FinancialWechatJoinRecord::find()->joinWith('wechat')->where(['day_time' => strtotime('today')])->andWhere(['pre_financial_wechat_join_record.status'=>1])->asArray()->all();
            return $this->render('today-fee-record',['model'=>$model]);
        }else{
            $model = FinancialWechatJoinRecord::find()->joinWith('wechat')->where(['day_time' => $time,'wechat_id'=>$wechat_id,'type'=>1])->andWhere(['pre_financial_wechat_join_record.status'=>1])->orderBy('created_at desc')->asArray()->all();
            return $this->render('day-fee-record',['model'=>$model]);
        }
    }


    public function actionAlreadyDelete(){

        $data = FinancialWechatJoinRecord::find()->joinWith('wechat')->andWhere(['pre_financial_wechat_join_record.status'=>0]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('already-delete',[
            'model' => $model,
            'pages' => $pages,
        ]);
    }

    public function actionDeleteRecordBack($id){

        $model = FinancialWechatJoinRecord::findOne($id);
        $model->status = 1;
        if($model->update()){
            return $this->redirect(Yii::$app->request->referrer);
        }

    }

    /**
     * @param null $week
     * @param null $mouth
     * @return string
     */
    public function actionEverydayFeeRecord($week=null,$mouth = null){

        $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['day_time'=>strtotime('today')])->andWhere(['status'=>[1,2]])->asArray()->all();

        $query_model1 = FinancialWechatJoinRecord::find()->select('sum(payment_amount) as sum,count(*) as count')->where(['day_time'=>strtotime('today')])->andWhere(['status'=>[1,2]])->asArray()->one();
        $query_model2 = FinancialWechatJoinRecord::find()->select('sum(payment_amount) as sum,count(*) as count')->where(['mouth_time'=>mktime(0,0,0,date('m',time()),date('t'),date('Y',time()))])->andWhere(['status'=>[1,2]])->asArray()->one();
        $query_model3 = FinancialWechatJoinRecord::find()->select('sum(payment_amount) as sum,count(*) as count')->where(['weekly_time'=>strtotime('next sunday')])->andWhere(['status'=>[1,2]])->asArray()->one();

        if($week!=null){
            $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['weekly_time'=>$week])->andWhere(['status'=>[1,2]])->asArray()->all();
        }

        if($mouth!=null){
            $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['mouth_time'=>$mouth])->andWhere(['status'=>[1,2]])->asArray()->all();
        }

        return $this->render('today-fee-record',['model'=>$model,'q_1'=>$query_model1,'q_2'=>$query_model2,'q_3'=>$query_model3]);
    }
    /**
     * @param null $week
     * @param null $mouth
     * @return string
     */
    public function actionSelfFeeRecord($week=null,$mouth = null){

        $user_id = Yii::$app->user->id;
        $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['day_time'=>strtotime('today')])->andWhere(['status'=>[1,2],'created_by'=>$user_id])->asArray()->all();

        $query_model1 = FinancialWechatJoinRecord::find()->select('sum(payment_amount) as sum,count(*) as count')->where(['day_time'=>strtotime('today')])->andWhere(['status'=>[1,2],'created_by'=>$user_id])->asArray()->one();
        $query_model2 = FinancialWechatJoinRecord::find()->select('sum(payment_amount) as sum,count(*) as count')->where(['mouth_time'=>mktime(0,0,0,date('m',time()),date('t'),date('Y',time()))])->andWhere(['status'=>[1,2],'created_by'=>$user_id])->asArray()->one();
        $query_model3 = FinancialWechatJoinRecord::find()->select('sum(payment_amount) as sum,count(*) as count')->where(['weekly_time'=>strtotime('next sunday')])->andWhere(['status'=>[1,2],'created_by'=>$user_id])->asArray()->one();

        if($week!=null){
            $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['weekly_time'=>$week])->andWhere(['status'=>[1,2],'created_by'=>$user_id])->asArray()->all();
        }

        if($mouth!=null){
            $model = FinancialWechatJoinRecord::find()->select('group_concat(id) as id,day_time')->groupBy('day_time')->orderBy('day_time desc')->where(['mouth_time'=>$mouth])->andWhere(['status'=>[1,2],'created_by'=>$user_id])->asArray()->all();
        }

        return $this->render('self-fee-record',['model'=>$model,'q_1'=>$query_model1,'q_2'=>$query_model2,'q_3'=>$query_model3]);
    }

    /**
     * @param $id
     * @return \yii\web\Response
     */
    public function actionDeleteRecord($id){
        $model = FinancialWechatJoinRecord::findOne($id);
        $model->status = 0;
        if($model->update()){
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    public function actionPassRecord($id){
        $model = FinancialWechatJoinRecord::findOne($id);
        $model->status = 2;
        if($model->update()){
            return $this->redirect(Yii::$app->request->referrer);
        }
    }
    /**
     * @param null $type
     * @return string
     */
    public function actionChoiceMouth($type=null){

        $model = FinancialWechatJoinRecord::find()->select('mouth_time')->andWhere(['status'=>[1,2]])->groupBy('mouth_time')->orderBy('mouth_time desc')->asArray()->all();
        return $this->render('choice-mouth',['model'=>$model,'type'=>$type]);
    }
    /**
     * @param null $type
     * @return string
     */
    public function actionSelfChoiceMouth($type=null){

        $model = FinancialWechatJoinRecord::find()->select('mouth_time')->andWhere(['status'=>[1,2]])->groupBy('mouth_time')->orderBy('mouth_time desc')->asArray()->all();
        return $this->render('self-choice-mouth',['model'=>$model,'type'=>$type]);
    }

    /**
     * @param null $mouth
     * @return string
     */
    public function actionChoiceWeek($mouth=null){

        $model = FinancialWechatJoinRecord::find()->select('weekly_time')->andWhere(['status'=>[1,2]])->groupBy('weekly_time')->orderBy('weekly_time desc')->where(['mouth_time'=>$mouth])->asArray()->all();
        return $this->render('choice-week',['model'=>$model]);

    }

    /**
     * @return string
     */
    public function actionPastFeeRecord(){

        $model = FinancialWechatJoinRecord::find()->joinWith('wechat')->andWhere(['status'=>[1,2]])->where(['day_time' => strtotime('today')])->asArray()->all();
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

    /**
     * @return string
     */
    public function actionChoiceTime(){

        if(!empty(Yii::$app->request->get('start_time'))){

            $start_time = strtotime(Yii::$app->request->get('start_time'));
            $end_time = strtotime(Yii::$app->request->get('end_time'));

            $model = FinancialWechatJoinRecord::find()->select("platform,sum(payment_amount) as pa,count(platform) as platform_c")->where(['between','day_time',$start_time,$end_time])->andWhere(['status'=>[1,2]])->groupBy('platform')->asArray()->all();

            echo "<table class='table table-bordered' style='background-color: #fff;text-align: center;border: none;margin-bottom: 0px;'>
                    <tr><td colspan='3'><h3>".date('Y-m-d',$start_time)." - ".date('Y-m-d',$end_time)."销售收入明细表</h3></td></tr>
                    <tr><th style='text-align: center;'>平台</th><th style='text-align: center;'>入会客服名称及金额</th><th style='text-align: center;'>总金额</th></tr>";
            $sum = 0;
            foreach ($model as $key=>$item){
                $sum += $item['pa'];
                $query = FinancialWechatJoinRecord::find()->select("created_by,sum(payment_amount) as pas,count(created_by) as u_count")->where(['between','day_time',$start_time,$end_time])->andWhere(['platform'=>$item['platform']])->andWhere(['status'=>[1,2]])->groupBy('created_by')->asArray()->all();
                echo "<tr>
                    <td style='vertical-align:middle;border-right: none;'>$item[platform]</td>
                    <td style='padding: 0;border:none !important;'>
                        <table class='table table-bordered' style='margin-bottom: 0;border:none;'>";
                            foreach ($query as $list):
                                $user = User::findOne($list['created_by'])->nickname;
                                echo "<tr>
                                    <td width='50%'>$user</td>
                                    <td>$list[pas]</td>
                                    </tr>";
                             endforeach;
                       echo "</table>
                    </td>
                    <td style='vertical-align:middle;border-left: none;'>{$item['pa']}</td>
                </tr>";
            }
            echo "<tr><td colspan='2'>总计</td><td style='background-color: yellow;'>$sum</td></tr></table>";
        }else{
            return $this->render('choice-time',['start_time'=>date('Y-m-01',time()),'end_time'=>date('Y-m-d',time()),]);
        }

    }

    public function actionMomAnDetail(){

        $choice_time = FinancialWechatJoinRecord::find()->select("day_time")->orderBy('day_time desc')->asArray()->all();

        if(!empty(Yii::$app->request->get('end_time'))){

            $end_time = Yii::$app->request->get('end_time');
            $dateItem = $this->getData($end_time);
            $start_time = $dateItem[4];

            $platform = ArrayHelper::map(FinancialWechatPlatform::find()->asArray()->all(),'id','platform_name');

            $model = new FinancialWechatJoinRecord();

            $model_last_zero = $model::find()->select("platform,sum(payment_amount) as pa,day_time")->where(['between','day_time',$start_time,$end_time])->andWhere(['status'=>[1,2]])->groupBy('platform')->asArray()->all();
            $model_last_first = $model::find()->select("platform,sum(payment_amount) as pa,day_time")->where(['between','day_time',$dateItem[2],$dateItem[3]])->andWhere(['status'=>[1,2]])->groupBy('platform')->asArray()->all();
            $model_last_second = $model::find()->select("platform,sum(payment_amount) as pa,day_time")->where(['between','day_time',$dateItem[7],$dateItem[6]])->andWhere(['status'=>[1,2]])->groupBy('platform')->asArray()->all();

            $zero = ArrayHelper::map($model_last_zero,'platform','pa');
            $zero0 = !empty($zero[$platform[1]])?$zero[$platform[1]]:0;
            $zero1 = !empty($zero[$platform[3]])?$zero[$platform[3]]:0;
            $zero2 = !empty($zero[$platform[4]])?$zero[$platform[4]]:0;
            $z = array_sum($zero);
            $first = ArrayHelper::map($model_last_first,'platform','pa');
            $first0 = !empty($first[$platform[1]])?$first[$platform[1]]:'';
            $first1 = !empty($first[$platform[3]])?$first[$platform[3]]:'';
            $first2 = !empty($first[$platform[4]])?$first[$platform[4]]:'';
            $f = array_sum($first);
            $first_percent = $this->percent($z,$f);
            $first_percent_0 = $this->percent($zero0,$first0);
            $first_percent_1 = $this->percent($zero1,$first1);
            $first_percent_2 = $this->percent($zero2,$first2);

            $second = ArrayHelper::map($model_last_second,'platform','pa');
            $second0 = !empty($second[$platform[1]])?$second[$platform[1]]:'';
            $second1 = !empty($second[$platform[3]])?$second[$platform[3]]:'';
            $second2 = !empty($second[$platform[4]])?$second[$platform[4]]:'';
            $s = array_sum($second);
            $second_percent = $this->percent($z,$s);
            $second_percent_0 = $this->percent($zero0,$second0);
            $second_percent_1 = $this->percent($zero1,$second1);
            $second_percent_2 = $this->percent($zero2,$second2);

            $time_1 = date('n月份收入',$dateItem[4]);
            $time_1_1 = date('n月份',$dateItem[4]);
            $time_1_s = date('Y-m-d',$dateItem[4]);
            $time_1_e = date('Y-m-d',$dateItem[5]);

            $time_2 = date('同期n月份环比增长',$dateItem[2]);
            $time_2_s = date('Y-m-d',$dateItem[2]);
            $time_2_e = date('Y-m-d',$dateItem[3]);

            $time_3 = date('同期n月份环比增长',$dateItem[6]);
            $time_3_s = date('Y-m-d',$dateItem[7]);
            $time_3_e = date('Y-m-d',$dateItem[6]);

            $html = <<<eof
<table class="table table-bordered text-center">
    <tr><th colspan=4>各个平台销售收入参考数据</th></tr>
    <tr><th></th><th>$time_1_s ~ $time_1_e</th><th></th><th>$time_2_s ~ $time_2_e</th><th>$time_3_s ~ $time_3_e</th></tr>
    <tr><th>平台</th><th>$time_1</th><th>$time_1_1</th><th>$time_2</th><th>$time_3</th></tr>
    <tr><td>$platform[1]</td><td>$zero0</td><td>$platform[1]</td><td>$first_percent_0</td><td>$second_percent_0</td></tr>
    <tr><td>$platform[3]</td><td>$zero1</td><td>$platform[3]</td><td>$first_percent_1</td><td>$second_percent_1</td></tr>
    <tr><td>$platform[4]</td><td>$zero2</td><td>$platform[4]</td><td>$first_percent_2</td><td>$second_percent_2</td></tr>
    <tr style=background-color:yellow><td>总计</td><td>$z</td><td>总计</td><td>$first_percent</td><td>$second_percent</td></tr>
</table>  
eof;
echo $html;

        }else{
            return $this->render('mom-an-detail',['end_time'=>date('Y-m-d',time()),'choice_time'=>ArrayHelper::map($choice_time,'day_time','day_time')]);
        }

    }


    protected function percent($q,$e){

        if($q!=0){
            $r = (round(($q-$e)/$q,3)*100).'%';
        }else{
            $r = '0%';
        }
        return $r;
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

        $model_this = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','day_time',$this_start_time,$this_end_time])->andWhere(['status'=>[1,2]])->asArray()->one();
        $model_last = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','day_time',$last_start_time,$last_end_time])->andWhere(['status'=>[1,2]])->asArray()->one();
        $model_past = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','day_time',$past_start_time,$past_end_time])->andWhere(['status'=>[1,2]])->asArray()->one();

        $model_1 = ArrayHelper::map(FinancialWechatJoinRecord::find()->orderBy('day_time desc')->andWhere(['status'=>[1,2]])->asArray()->all(),'day_time','day_time');
        $model_2 = ArrayHelper::map(FinancialWechatJoinRecord::find()->orderBy('mouth_time desc')->andWhere(['status'=>[1,2]])->asArray()->all(),'mouth_time','mouth_time');

        return $this->render('mom-an',[
            'model_this'=>$model_this,'model_last'=>$model_last,'model_past'=>$model_past,'this_start_time'=>$this_start_time,
            'this_end_time'=>$this_end_time,'last_start_time'=>$last_start_time,'last_end_time'=>$last_end_time,
            'past_start_time'=>$past_start_time,'past_end_time'=>$past_end_time,'model_1'=>$model_1,'model_2'=>$model_2
        ]);
    }

    public function actionMomAnName(){

        $choice_time = FinancialWechatJoinRecord::find()->select("day_time")->orderBy('day_time desc')->asArray()->all();

        if(!empty(Yii::$app->request->get('end_time'))){
            $end_time = Yii::$app->request->get('end_time');
            $dateItem = $this->getData($end_time);
            $start_time = $dateItem[4];
            $model = FinancialWechatJoinRecord::find()->select("platform,sum(payment_amount) as pa,created_by")->where(['between','day_time',$start_time,$end_time])->andWhere(['status'=>[1,2]])->groupBy('created_by')->orderBy('pa desc')->asArray()->all();
            $time_1 = date('n月份收入',$dateItem[4]);
            $time_1_1 = date('n月份',$dateItem[4]);
            $time_1_s = date('Y-m-d',$dateItem[4]);
            $time_1_e = date('Y-m-d',$dateItem[5]);

            $time_2 = date('同期n月份环比增长',$dateItem[2]);
            $time_2_s = date('Y-m-d',$dateItem[2]);
            $time_2_e = date('Y-m-d',$dateItem[3]);

            $time_3 = date('同期n月份环比增长',$dateItem[6]);
            $time_3_s = date('Y-m-d',$dateItem[7]);
            $time_3_e = date('Y-m-d',$dateItem[6]);

        $html = "<table class='table table-bordered text-center'>
        <tr><th colspan=6>各客服销售收入参考数据</th></tr>
        <tr><th rowspan='2' style='vertical-align: middle'>姓名</th><th rowspan='2' style='vertical-align: middle'>所属平台</th><th>$time_1_s ~ $time_1_e</th><th></th><th>$time_2_s ~ $time_2_e</th><th>$time_3_s ~ $time_3_e</th></tr>
        <tr><th>$time_1</th><th>$time_1_1</th><th><span id='p_1s' style='display: none;'>$time_2</span><a id='p_1' onclick=calc('p_1',$dateItem[2],$dateItem[3])>$time_2</a></th><th><span id='p_2s' style='display: none;'>$time_3</span><a id='p_2' onclick=calc('p_2',$dateItem[7],$dateItem[6])>$time_3</a></th></tr>";
        $sum = 0;
        foreach ($model as $item){
            $sum+=$item['pa'];
            $username = User::findOne($item['created_by'])->nickname;
            $html.="<tr class='username' data-id=$item[created_by]><td>$username</td><td>$item[platform]</td><td class='pa'>$item[pa]</td><td>$username</td><td class='p_1'></td><td class='p_2'></td></tr>";
        }
        $html .= "<tr style=background-color:yellow><td colspan='2'>总计</td><td>$sum</td><td>总计</td><td></td><td></td></tr></table>";
        return $html;
        }

        return $this->render('mom-an-name',['choice_time'=>ArrayHelper::map($choice_time,'day_time','day_time')]);
    }

    public function actionP($uid,$s,$e,$t){

        $model_this = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['created_by'=>$uid])->andWhere(['between','day_time',$s,$e])->andWhere(['status'=>[1,2]])->asArray()->one();
        $r = $this->percent($t,$model_this['sum']);
        echo $r;

    }
    /**
     * @param $date
     */
    public function actionD($date){

        $getDate = $this->getData($date);

        $last_start_time = $getDate[2];
        $last_end_time = $getDate[3];

        $this_start_time = $getDate[4];
        $this_end_time = $getDate[5];

        $past_start_time = $getDate[0];
        $past_end_time = $getDate[1];

        $model_this = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','day_time',$this_start_time,$this_end_time])->andWhere(['status'=>[1,2]])->asArray()->one();
        $model_last = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','day_time',$last_start_time,$last_end_time])->andWhere(['status'=>[1,2]])->asArray()->one();
        $model_past = FinancialWechatJoinRecord::find()->select("sum(payment_amount) as sum")->where(['between','day_time',$past_start_time,$past_end_time])->andWhere(['status'=>[1,2]])->asArray()->one();

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

    /**
     * @param $date
     * @return array
     */
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

        $date_7 = strtotime(date('Y',$date) . '/' . (date('m',$date)-2) . '/' . date('d',$date));
        $date_8 = strtotime(date('Y',$date) . '/' . (date('m',$date)-2) . '/' . 1);

        $dateArr = array($date_1,$date_2,$date_4,$date_3,$date_5,$date_6,$date_7,$date_8);

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
