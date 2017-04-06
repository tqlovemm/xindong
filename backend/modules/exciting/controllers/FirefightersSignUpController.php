<?php

namespace backend\modules\exciting\controllers;

use backend\models\User;
use backend\modules\app\models\UserData;
use backend\modules\dating\models\UserWeichatPush;
use backend\modules\exciting\models\OtherTextPic;
use common\components\SaveToLog;
use frontend\modules\weixin\models\UserWeichat;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\Pagination;
use yii\myhelper\AccessToken;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use frontend\modules\weixin\models\FirefightersSignUp;

/**
 * FirefightersSignUpController implements the CRUD actions for FirefightersSignUp model.
 */
class FirefightersSignUpController extends Controller
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
     * @param string $number
     * @param int $type
     * @return string
     */
    public function actionIndex($number='',$type=1)
    {
        $user_id = \backend\models\User::getId($number);
        $searchModel = new FirefightersSignUp();
        $query = $searchModel::find()->joinWith('sign');
        if($number!=''){
            $data = $query->where(['pre_firefighters_sign_up.user_id'=>$user_id])->orderBy('pre_firefighters_sign_up.created_at desc')->asArray();
        }else{
            if($type==0){
                $data = $query->where(['pre_firefighters_sign_up.status'=>0])->asArray();
            }elseif ($type==1){
                $data = $query->orderBy('pre_firefighters_sign_up.created_at desc')->asArray();
            }elseif ($type==2){
                $data = $query->where(['pre_firefighters_sign_up.status'=>[1,2,3]])->asArray();
            }elseif($type==3){
                $data = $query->orderBy('pre_firefighters_sign_up.created_at asc')->asArray();
            }elseif($type==4){
                $data = $query->orderBy('pre_firefighters_sign_up.user_id asc')->asArray();
            }else{
                $noPush = array();
                $user = new User();
                $wxuser = new UserWeichat();
                $push = new UserWeichatPush();
                $signup = $searchModel::find()->select('user_id,number')->where(['status'=>1])->asArray()->all();
                foreach ($signup as $key=>$up){
                    $user_number = $user::getNumber($up['user_id']);
                    $openid = $wxuser::findOne(['number'=>$user_number]);
                    $signup[$key]['openid'] = empty($openid->openid)?'':$openid->openid;
                    $already_push = $push::findOne(['openid'=>$signup[$key]['openid'],'number'=>$up['number']]);
                    if(empty($already_push)){
                        array_push($noPush,$up['user_id']);
                    }
                }
                $data = $query->where(['pre_firefighters_sign_up.user_id'=>$noPush,'pre_firefighters_sign_up.status'=>1])->orderBy('pre_firefighters_sign_up.created_at desc')->asArray();
            }
        }

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

       return $this->render('index',[
           'model' => $model,
           'pages' => $pages,
       ]);
   /*     $searchModel = new FirefightersSignUpSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
    }

    /**
     * Displays a single FirefightersSignUp model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionReback($id,$status){
        $model = FirefightersSignUp::findOne($id);
        $sign = OtherTextPic::findOne(['pid'=>$model->sign_id]);
        $model->status = $status;
        $model->handler = Yii::$app->user->identity->username;
        $model->reason = "管理员{$model->handler}撤销";
        if($model->update()){

            try{
                if($status==2){
                    $result = '失败';
                    $userData = UserData::findOne(['user_id'=>$model->user_id]);
                    $userData->jiecao_coin += $sign->coin;
                    if($userData->update()){
                        SaveToLog::userBgRecord("管理员{$model->handler}撤销{$sign->number}福利救火$result,返还节操币:$sign->coin",$model->user_id);
                    }

                }

            }catch (Exception $e){
                throw new ErrorException($e->getMessage());
            }
        }
        return $this->redirect('index');
    }

    public function actionPassOrNot($id,$status,$reason=''){

        $model = FirefightersSignUp::findOne($id);
        $sign = OtherTextPic::findOne(['pid'=>$model->sign_id]);
        $model->status = $status;
        $model->handler = Yii::$app->user->identity->username;
        $model->reason = $reason;
        if($model->update()){

            try{
                if($status==2){
                    $result = '失败';
                    $userData = UserData::findOne(['user_id'=>$model->user_id]);
                    $userData->jiecao_coin += $sign->coin;
                    if($userData->update()){
                        SaveToLog::userBgRecord("管理员{$model->handler}审核{$sign->number}福利救火$result,返还节操币:$sign->coin",$model->user_id);
                    }

                }

            }catch (Exception $e){
                throw new ErrorException($e->getMessage());
            }
        }

        return $this->redirect('index');

    }

    /**
     * Creates a new FirefightersSignUp model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FirefightersSignUp();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FirefightersSignUp model.
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
     * Deletes an existing FirefightersSignUp model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeletePushRecord($openid,$number){

        $model = UserWeichatPush::findOne(['openid'=>$openid,'number'=>$number,'status'=>2]);

        if(!empty($model)){

            if($model->delete()){
                echo json_encode('清空成功，可以点击重新推送');exit();
            }else{
                echo json_encode($model->errors);exit();
            }
        }

        echo json_encode('清空失败,不存在推送记录');
    }

    public function actionSendTemp($openid,$number){

        $model = new UserWeichatPush();

        if(!empty($model::findOne(['openid'=>$openid,'number'=>$number,'status'=>2]))){
            echo json_encode('推送失败!!对不起您已经推送给他过了!');exit();
        }
        $model->number = $number;
        $model->openid = $openid;
        $model->remark = Yii::$app->setting->get('remarks');
        $model->status = 2;
        if($model->save()) {
            $url = "http://13loveme.com/weixin/firefighters/pull-fire?number=$number&id=".$model->id;
            $data = array(
                "touser" => $openid,
                "template_id" => "sj6-k6LNiMH1n86EuDcy0BA5QJGfqaNThVtVN-i8W_w",
                "url" => $url,
                "topcolor" => "#FF0000",
                "data" => array(
                    "first" => array(
                        "value" => "十三平台觅约报名通知！",
                        "color" => "#000"
                    ),
                    "keyword1" => array(
                        "value" => "{$model->id}",
                        "color" => "#000"
                    ),
                    "keyword2" => array(
                        "value" => "救火福利报名审核通过,24小时之内,点击即可获取对方联系方式,如果对方不通过或拒绝添加好友,请及时联系客服处理.",
                        "color" => "#000"
                    ),
                    "keyword3" => array(
                        "value" => date('Y-m-d', time()),
                        "color" => "#000"
                    ),
                    "remark" => array(
                        "value" => "感谢您的参与！",
                        "color" => "#000"
                    )
                )
            );
            $msg = json_decode($this->sendTemp($data), true);
            if($msg['errcode']!=0){
                $model->delete();
            }
            if($msg['errcode']==43004){
                echo json_encode('推送失败!!需要接收者关注公众号【心动三十一天】');exit();
            }
            if($msg['errcode']==42001){
                echo json_encode('推送失败!!access_token超时,请点击上方刷新access_token按钮');exit();
            }
            if($msg['errcode']==0){
                echo json_encode('推送成功!!');exit();
            }
            echo json_encode($msg['errmsg']);
        }else{
            echo '数据未保存';
        }
    }

    public function actionSendTempToAll($number,$pid,$name){

        $openids = UserWeichat::find()->select('openid')->where(['address'=>$name])->asArray()->column();
        $sum = 0;
        $model = new UserWeichatPush();
        foreach ($openids as $openid) {
            if (!empty($model::findOne(['openid' => $openid, 'number' => $number, 'status' => 3]))) {
                continue;
            }
            $model->number = $number;
            $model->openid = $openid;
            $model->status = 3;
            if ($model->save()) {
                $sum++;
                $url = "http://13loveme.com/firefighters?pid=$pid";
                $data = array(
                    "touser" => $openid,
                    "template_id" => "sj6-k6LNiMH1n86EuDcy0BA5QJGfqaNThVtVN-i8W_w",
                    "url" => $url,
                    "topcolor" => "#FF0000",
                    "data" => array(
                        "first" => array(
                            "value" => "十三平台救火妹子发布通知！",
                            "color" => "#000"
                        ),
                        "keyword1" => array(
                            "value" => "{$pid}",
                            "color" => "#000"
                        ),
                        "keyword2" => array(
                            "value" => "救火有新妹子发布了，赶快戳我进来看看吧。",
                            "color" => "#000"
                        ),
                        "keyword3" => array(
                            "value" => date('Y-m-d', time()),
                            "color" => "#000"
                        ),
                        "remark" => array(
                            "value" => "感谢您的参与！",
                            "color" => "#000"
                        )
                    )
                );
                $msg = json_decode($this->sendTemp($data), true);
                if ($msg['errcode'] != 0) {
                    $model->delete();
                    continue;
                }
            }
        }
        echo "全部推送完成，总计:".count($openids)."人，成功推送:{$sum}人";
    }

    /**
     * @param $data
     * @return mixed|string
     * 发送模板消息
     */
    public function sendTemp($data){

        $access = new AccessToken();
        $access_token = $access->getAccessToken();

        $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=".$access_token;

        return $this->postData($url,json_encode($data));

    }

    public function postData($url,$data){
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.0)');
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($ch, CURLOPT_AUTOREFERER, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $tmpInfo = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        return $tmpInfo;
    }

    /**
     * Finds the FirefightersSignUp model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FirefightersSignUp the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FirefightersSignUp::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
