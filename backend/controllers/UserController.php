<?php

namespace backend\controllers;
use backend\components\AddRecord;
use backend\models\CollectingFilesText;
use backend\models\ThirthFiles;
use backend\models\UploadForm;
use backend\models\UserPayment;
use backend\modules\bgadmin\models\BgadminMember;
use common\components\SaveToLog;
use frontend\models\UserProfile;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\Pagination;
use backend\models\UserDatingSearch;
use backend\models\UserInfo;
use backend\modules\dating\models\DatingSignup;
use backend\modules\dating\models\RechargeRecord;
use Yii;
use backend\models\User;
use backend\models\UserSearch;
use common\components\BaseController;
use yii\db\Query;
use yii\myhelper\Easemob;
use yii\myhelper\SystemMsg;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\web\ForbiddenHttpException;
use yii\web\UploadedFile;

/**
 * UserController implements the CRUD actions for User model.
 */

class UserController extends BaseController
{

    public  $enableCsrfValidation = false;
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'create', 'delete','disconnect','address-info', 'upload', 'update','update-address','user-info','user-dating','user-dating-total','user-file-total','delete-payment','show-payment','dating-success-dropped'],
                        'allow' => true,
                        'roles' => ['@'],
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
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    public function actionDisconnect($username){

        $data = $this->setMes()->disconnect($username);
        return var_dump($data);

    }
    protected function setMes(){

        $options = array(
            'client_id'  => Yii::$app->params['client_id'],   //你的信息
            'client_secret' => Yii::$app->params['client_secret'],//你的信息
            'org_name' => Yii::$app->params['org_name'],//你的信息
            'app_name' => Yii::$app->params['app_name'] ,//你的信息
        );
        $e = new Easemob($options);
        return $e;
    }
    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($model->status == 0){
                $this->setMes()->disconnect($model->username);
            }
            if ($model->update()) {
                $bg = BgadminMember::findOne(['number'=>User::getNumber($model->id)]);
                if(!empty($bg)){
                    $bg->vip = $model->groupid;
                    $bg->update();
                }

                Yii::$app->getSession()->setFlash('success', 'Save successfully');
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }
    public function actionAddressInfo($id){

        $model = UserProfile::findOne(['user_id'=>$id]);

        if ($model->load(Yii::$app->request->post())) {

            $data = Yii::$app->request->post();
            $address_1 = $address_2 = $address_3 = "";
            if(!empty($data['province1']))
                $address_1 = urldecode(json_encode(array('province'=>urlencode($data['province1']),'city'=>urlencode($data['city1']))));
            if(!empty($data['province2']))
                $address_2 = urldecode(json_encode(array('province'=>urlencode($data['province2']),'city'=>urlencode($data['city2']))));
            if(!empty($data['province3']))
                $address_3 = urldecode(json_encode(array('province'=>urlencode($data['province3']),'city'=>urlencode($data['city3']))));

            $model->address_1 = $address_1;
            $model->address_2 = $address_2;
            $model->address_3 = $address_3;

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            if ($model->update()) {
                $data_arr = array('description'=>"修改网站会员{$id}的资料信息",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
                Yii::$app->getSession()->setFlash('success', 'Save successfully');
            }
        }

        return $this->render('address-info',['model'=>$model]);
    }
    public function actionUpdateAddress($id)
    {
        $model = UserProfile::findOne(['user_id'=>$id]);
        $data = Yii::$app->request->post();
        $address_1 = $address_2 = $address_3 = "";
        if(!empty($data['province1']))
        $address_1 = urldecode(json_encode(array('province'=>urlencode($data['province1']),'city'=>urlencode($data['city1']))));
        if(!empty($data['province2']))
        $address_2 = urldecode(json_encode(array('province'=>urlencode($data['province2']),'city'=>urlencode($data['city2']))));
        if(!empty($data['province3']))
        $address_3 = urldecode(json_encode(array('province'=>urlencode($data['province3']),'city'=>urlencode($data['city3']))));

        $model->address_1 = $address_1;
        $model->address_2 = $address_2;
        $model->address_3 = $address_3;
        $old = json_encode($model->oldAttributes);
        $new = json_encode($model->attributes);

        if ($model->update()) {
            $data_arr = array('description'=>"修改网站会员{$id}的资料信息",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
            AddRecord::record($data_arr);
            Yii::$app->getSession()->setFlash('success', 'Save successfully');
        }

        return $this->render('address-info',['model'=>$model]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        if($model->delete()){
            $data_arr = array('description'=>"删除网站会员{$id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }
        return $this->redirect(['index']);
    }

    public function actionUserInfo(){

        $model = new UserInfo();

        if($model->load(Yii::$app->request->post())){

            if($model->type==0){
                $params = "id";
            }elseif($model->type==1){
                $params = "username";
            }elseif($model->type==2){
                $params = "number";
            }else{
                $params = "cellphone";
            }


            if($params=='number'){

                $params = "p.number";
                $user_info = Yii::$app->db->createCommand("select u.id,u.username,u.nickname,u.sex,u.cellphone,u.email,u.avatar,u.created_at,u.groupid,
                                                          d.jiecao_coin,d.frozen_jiecao_coin,
                                                          p.number,p.address_1,p.address_2,p.address_3,p.birthdate,p.height,p.weight,p.mark,p.make_friend,p.hobby
                                                  from {{%user_profile}} as p left join {{%user_data}} as d on d.user_id=p.user_id left join {{%user}} as u on u.id=p.user_id where $params='$model->content'")->queryOne();


            }else{

                $user_info = Yii::$app->db->createCommand("select u.id,u.username,u.nickname,u.sex,u.cellphone,u.email,u.avatar,u.created_at,u.groupid,
                                                          d.jiecao_coin,d.frozen_jiecao_coin,
                                                          p.number,p.address_1,p.address_2,p.address_3,p.birthdate,p.height,p.weight,p.mark,p.make_friend,p.hobby
                                                  from {{%user}} as u left join {{%user_data}} as d on d.user_id=u.id left join {{%user_profile}} as p on p.user_id=u.id where $params='$model->content'")->queryOne();


            }

            if(empty($user_info)){

                Yii::$app->session->setFlash('nobody','查询无此会员');
            }else{
                $data_arr = array('description'=>"查询会员{$params}：{$model->content}的个人信息",'data'=>json_encode($user_info),'old_data'=>'','new_data'=>'','type'=>4);
                AddRecord::record($data_arr);
            }

            return $this->render('user-info',['model'=>$model,'user_info'=>$user_info]);

        }

        return $this->render('user-info',['model'=>$model]);

    }

    public function actionShowPayment($id){

       // $model = (new Query())->from('pre_user_payment')->where(['user_id'=>$id])->all();

        $query = new Query;
        $query->from('{{%user_payment}}')
            ->where(['user_id'=>$id])->orderBy('created_at desc');
        $photos = Yii::$app->tools->Pagination($query);

        return $this->render('show-payment',[
            'model' => $photos['result'],
            'pages' => $photos['pages']
        ]);

    }
    public function actionDeletePayment($id){

        $model = UserPayment::findOne($id);
        $file = $model->payment_img;
        $delete = @unlink($file);
        if($delete&&$model->delete()){
            return $this->redirect(["show-payment",'id'=>$model->user_id]);
        }
    }
    public function actionUpload($id)
    {
        $model = new UploadForm();
        $query = new UserPayment();
        if (Yii::$app->request->isPost) {
            $model->file = UploadedFile::getInstance($model, 'file');

            if ($model->file && $model->validate()) {
                $abs_path = "uploads/payment/" . $id.'_'.time().rand(10000,99999) . '.' . $model->file->extension;
                $path = $model->file->saveAs($abs_path);

                if($path){

                    $query->payment_img = $abs_path;
                    $query->user_id = $id;
                    $query->extra =Yii::$app->request->post()['UploadForm']['extra'];
                    $query->save();
                    Yii::$app->session->setFlash('success','添加成功');
                }
            }
        }

        return $this->render("upload", ['model' => $model]);
    }

    public function actionUserDating(){


        $searchModel = new UserDatingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('user-dating', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionUserDatingTotal($type=1,$ids){
        
        $this->layout = 'other';

        if($type==1){

            $id=$ids;

        }else{

            $profile = (new Query())->select('user_id')->from('{{%user_profile}}')->where(['number'=>$ids])->one();

            if(empty($profile)){
                return '查询无此会员';
            }
            $id = $profile['user_id'];
        }
        $data = RechargeRecord::find()->select('id,user_id,updated_at,number,extra,status,handler,reason,status')->andWhere(['user_id'=>$id,'subject'=>3]);
        $result_count = Yii::$app->db->createCommand("select status,count(status) as total from {{%recharge_record}} where user_id=$id and subject=3 group by status")->queryAll();

        $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
        $model = $data->offset($pages->offset)->limit($pages->limit)->orderBy('created_at desc')->all();
        if(empty($model)){
            return '查询无此会员';
        }

        return $this->render('user-dating-total',[
           'model' => $model,
           'pages' => $pages,
           'result_count'=>$result_count,
        ]);


    }

    public function actionUserFileTotal($number){
        $this->layout = 'other';
        $modelClass = new ThirthFiles();
        $model = $modelClass::find()->where(['pre_collecting_files_text.id'=>$number])->joinWith('img')->asArray()->one();
        return $this->render('user-file-total',['model'=>$model]);



    }

    public function actionDatingSuccessDropped($id){

        $query = (new Query())->select('user_id,number,extra')->from('{{%recharge_record}}')->where(['id'=>$id])->one();

        if(!empty($query)){

            $extra = json_decode($query['extra'],true);
            $update_record = Yii::$app->db->createCommand()->update('{{%recharge_record}}',['status'=>12,'number'=>0,'refund'=>$query['number']],['id'=>$id])->execute();

            if($update_record){

                $update_jiecao = Yii::$app->db->createCommand("update pre_user_data set jiecao_coin = jiecao_coin+{$query['number']} where user_id={$query['user_id']}")->execute();

                if($update_jiecao){

                try{
                    new SystemMsg($query['user_id'],'密约失败',"很遗憾你的密约失败，系统退还你$query[number]节操币,密约编号$extra[number]",$extra['avatar'],$status=5);
                    SaveToLog::userBgRecord("管理员撤销觅约,返还节操币:{$query['number']}",$query['user_id']);
                }catch (Exception $e){
                    throw new ErrorException($e->getMessage());
                }
                    return $this->redirect(Yii::$app->request->referrer);
                }

            }

        }

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
