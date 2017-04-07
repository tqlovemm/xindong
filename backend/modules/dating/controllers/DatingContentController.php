<?php

namespace backend\modules\dating\controllers;

use backend\components\AddRecord;
use backend\models\User;
use backend\modules\dating\models\DatingContent;
use backend\modules\dating\models\RechargeRecord;
use backend\modules\dating\models\UserWeichatPush;
use backend\modules\setting\models\SystemMsg;
use common\components\SaveToLog;
use frontend\modules\member\models\UserVipTempAdjust;
use Yii;
use common\components\BaseController;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\myhelper\AccessToken;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
class DatingContentController extends BaseController
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
                        'actions' => ['index', 'view', 'delete','dating-signup','dating-signup-check','success-fail','to-check','send-temp','send-app','delete-push-record'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionView($id)
    {
        $model = $this->findModel($id);

        return $this->render('view', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){

            $data_array = array('description'=>"删除觅约id{$model->album_id}的一张图片",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_array);
        }

        return $this->redirect($_SERVER['HTTP_REFERER']);

    }

    public function actionDatingSignupCheck($type=1,$user_id = null){

        if($type==0){
            $data = RechargeRecord::find()->where(['to'=>[0],'status'=>[10],'subject'=>3,'platform'=>[0,2]]);
        }elseif($type==1){
            $data = RechargeRecord::find()->where(['to'=>[0],'status'=>[10,11,12],'subject'=>3,'platform'=>[0,2]])->orderBy('created_at desc');
        }elseif($type==2){
            $data = RechargeRecord::find()->where(['to'=>[0],'status'=>[10,11,12],'subject'=>3,'platform'=>[0,2]])->orderBy('created_at asc');
        }else{
            $userID = $user_id;
            if($user_id!=null){
                if($type==5){
                    $userID = User::getId($user_id);
                }
            }
            $data = RechargeRecord::find()->where(['status'=>[10,11,12],'subject'=>3,'user_id'=>$userID])->orderBy('created_at desc');
        }

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->addOrderBy("updated_at desc")->all();
           return $this->render('dating-signup-check',[
               'models' => $model,
               'pages' => $pages,
           ]);

    }
    public function actionSuccessFail(){

        $status=Yii::$app->request->post('status');
        $id=Yii::$app->request->post('id');
        $reason=Yii::$app->request->post('reason');
        $platform=Yii::$app->request->post('platform');

        $system_msg = new SystemMsg();

        $query = RechargeRecord::findOne($id);

        $user_id = $query->user_id;
        $return = $query->number;

        $avatar = json_decode($query->extra,true)['avatar'];

        $query->handler = Yii::$app->user->identity->username;
        $query->status = $status;
        $query->reason = $reason;
        if($status==9){
            $query->to = 1;
        }
        if($status==11){
            $vip_check = UserVipTempAdjust::findOne(['user_id'=>$user_id,'status'=>[10,11]]);
            $get_vip = User::getVip($user_id);
            if(!empty($vip_check)&&($get_vip==2)&&(RechargeRecord::find()->where(['user_id'=>$user_id,'status'=>11])->count())>=2){

                if($vip_check->status!=11){
                    $vip_check->status = 11;
                    $vip_check->update();
                    Yii::$app->db->createCommand("update {{%user}} set groupid = 2 where id={$user_id}")->execute();
                }
                return "该会员为试用包会员，已经成功觅约2人，请点击失败";
            }
        }

        if($status==12){
            $back = Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+$return where user_id=$user_id")->execute();
            if($back){
                $query->refund = $return;
                $query->number = $query->number-$return;
            }
        }


        if($query->update()){

            try{
                $result='';
                if($status==12){
                    $result = '失败';
                    SaveToLog::userBgRecord("管理员{$query->handler}审核密约$result,返还节操币:$return",$user_id);
                }elseif($status==11){
                    $result = '成功';

                    //app推送女生二维码

                }
            }catch (Exception $e){
                throw new ErrorException($e->getMessage());
            }

            if($status!=9){
                $system_msg->status = 2;
                $system_msg->user_id = $user_id;
                $system_msg->title = "密约报名";
                $system_msg->content = "您的最新密约报名已经有处理结果了，报名$result";
                $system_msg->file = $avatar;
                $system_msg->save();
            }

            if(strpos(Yii::$app->request->referrer,'to-check')!==false){
                return $this->redirect('to-check');
            }else{
                return $this->redirect(Yii::$app->request->referrer);
            }
        }
    }

    public function actionToCheck($type=1,$user_id = null){


        if($type==0){
            $data = RechargeRecord::find()->where(['to'=>[1],'status'=>[9],'subject'=>3,'platform'=>[0,2]]);
        }elseif($type==1){
            $data = RechargeRecord::find()->where(['to'=>[1],'status'=>[9,11,12],'subject'=>3,'platform'=>[0,2]])->orderBy('created_at desc');
        }elseif($type==2){
            $data = RechargeRecord::find()->where(['to'=>[1],'status'=>[9,11,12],'subject'=>3,'platform'=>[0,2]])->orderBy('created_at asc');
        }else{
            $userID = $user_id;
            if($user_id!=null){
                if($type==5){
                    $userID = User::getId($user_id);
                }
            }
            $data = RechargeRecord::find()->where(['status'=>[9],'subject'=>3,'user_id'=>$userID])->orderBy('created_at desc');
        }

   /*   $data = RechargeRecord::find()->andWhere(['subject'=>3,'status'=>9]);
        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->addOrderBy("updated_at desc")->all();
*/

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '15']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->addOrderBy("updated_at desc")->all();
        return $this->render('to-check',[
            'models' => $model,
            'pages' => $pages,
        ]);


    }

    public function actionDeletePushRecord($openid,$number){

        $model = UserWeichatPush::findOne(['openid'=>$openid,'number'=>$number,'status'=>1]);

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
        if(!empty($model::findOne(['openid'=>$openid,'number'=>$number,'status'=>1]))){
            echo json_encode('推送失败！你已经推送给他过了');exit();
        }else{
            $model->number = $number;
            $model->openid = $openid;
            $model->remark = Yii::$app->setting->get('remarks');
            if($model->save()){
                $url = "http://13loveme.com/weixin/firefighters/pull-girl?number=$number&id=".$model->id;
                $data = array(
                    "touser"=>$openid,
                    "template_id"=>"sj6-k6LNiMH1n86EuDcy0BA5QJGfqaNThVtVN-i8W_w",
                    "url"=>$url,
                    "topcolor"=>"#FF0000",
                    "data"=>array(
                        "first"=> array(
                            "value"=>"十三平台觅约报名通知！",
                            "color"=>"#000"
                        ),
                        "keyword1"=>array(
                            "value"=>"对方女生编号：{$number}",
                            "color"=>"#000"
                        ),
                        "keyword2"=> array(
                            "value"=>"觅约报名审核通过,24小时之内,点击即可获取对方联系方式,如果对方不通过或拒绝添加好友,请及时联系客服处理.",
                            "color"=>"#000"
                        ),
                        "keyword3"=> array(
                            "value"=>date('Y-m-d',time()),
                            "color"=>"#000"
                        ),
                        "remark"=>array(
                            "value"=>"感谢您的参与！",
                            "color"=>"#000"
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
                var_dump($model->errors);
            }
        }

    }

    public function actionSendApp($img,$username,$word="您的密约报名成功，请及时添加女生二维码！"){


        $data = array(
            'username'=>$username,
            'imgPath'=>$img,
            'word'=>$word."添加时请备注".Yii::$app->setting->get('remarks'),
        );
        $url = "https://13loveme.com/v9/send-msgs";
        return $this->postData($url,$data);

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

    public function postFromData($url,$data){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_USERAGENT,'Opera/9.80 (Windows NT 6.2; Win64; x64) Presto/2.12.388 Version/12.15');
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        $r = curl_exec($curl);
        curl_close($curl);

        return $r;
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

    protected function findModel($id)
    {
        if (($model = DatingContent::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
