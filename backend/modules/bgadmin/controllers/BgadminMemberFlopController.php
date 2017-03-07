<?php

namespace backend\modules\bgadmin\controllers;

use backend\modules\dating\models\UserWeichatPush;
use frontend\modules\weixin\models\UserWeichat;
use Yii;
use backend\modules\bgadmin\models\BgadminMemberFlop;
use backend\modules\bgadmin\models\BgadminMemberFlopSearch;
use yii\data\Pagination;
use yii\myhelper\AccessToken;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BgadminMemberFlopController implements the CRUD actions for BgadminMemberFlop model.
 */
class BgadminMemberFlopController extends Controller
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
     * Lists all BgadminMemberFlop models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BgadminMemberFlopSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }


    public function actionFlopPush(){

        $data = BgadminMemberFlop::find()->where('created_at>1481696646')->orderBy('created_at desc');
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->all();

       return $this->render('flop-push',[
           'model' => $model,
           'pages' => $pages,
       ]);
    }

    public function actionDeletePushRecord($openid,$number){

        $model = UserWeichatPush::findOne(['openid'=>$openid,'number'=>$number,'status'=>5]);

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

        if(!empty($model::findOne(['openid'=>$openid,'number'=>$number,'status'=>5]))){
            echo json_encode('推送失败!!对不起您已经推送给他过了!');exit();
        }
        $model->number = $number;
        $model->openid = $openid;
        $model->status = 5;
        if($model->save()) {
            $url = "http://13loveme.com/weixin/firefighters/pull-fire?number=$number&id=".$model->id;
            $data = array(
                "touser" => $openid,
                "template_id" => "sj6-k6LNiMH1n86EuDcy0BA5QJGfqaNThVtVN-i8W_w",
                "url" => $url,
                "topcolor" => "#FF0000",
                "data" => array(
                    "first" => array(
                        "value" => "十三平台翻牌通知！",
                        "color" => "#000"
                    ),
                    "keyword1" => array(
                        "value" => "{$model->id}",
                        "color" => "#000"
                    ),
                    "keyword2" => array(
                        "value" => "您在我们平台的档案信息被妹子看中啦，快点开查看对方联系方式吧，24小时内有效。",
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
     * Displays a single BgadminMemberFlop model.
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
     * Creates a new BgadminMemberFlop model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BgadminMemberFlop();
        $data = array();
        if ($model->load(Yii::$app->request->post())) {

            $model->floping_number = trim($model->floping_number);
            $flops = explode(',',$model->floped);
            $flops = array_filter($flops);
            foreach ($flops as $key=>$flop){
                $key = array();
                $flop = trim($flop);
                array_push($key,$model->floping_number,$flop,time(),time(),Yii::$app->user->identity->username);
                $aa = array_values($key);
                array_push($data,$aa);
            }

            Yii::$app->db->createCommand()->batchInsert('pre_bgadmin_member_flop', ['floping_number', 'floped_number','created_at','updated_at','created_by'],$data)->execute();
            return $this->redirect('index');
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BgadminMemberFlop model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            $model->floped = 'fasd';
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->id]);
            }else{
                return var_dump($model->errors);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BgadminMemberFlop model.
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
     * Finds the BgadminMemberFlop model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BgadminMemberFlop the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BgadminMemberFlop::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
