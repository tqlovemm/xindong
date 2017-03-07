<?php

namespace backend\modules\setting\controllers;

use backend\components\AddRecord;
use backend\models\User;
use backend\modules\seventeen\models\SeventeenWeiUser;
use frontend\models\CollectingSeventeenFilesText;
use frontend\models\CollectingFilesText;
use frontend\modules\member\models\UserVipTempAdjust;
use Yii;
use backend\modules\setting\models\Setting;
use yii\db\Query;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use backend\modules\setting\models\SendUrlToUser;
/**
 * IndexController implements the CRUD actions for Setting model.
 */
class DefaultController extends BaseController
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','vip-temp','vip-temp-tj', 'view', 'create', 'delete', 'update','send-url','send-seventeen-man-url','predefined-jiecao-coin','send-collecting-url','send-collecting-seventeen-url'],
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
     * Lists all Setting models.
     * @return mixed
     */
    public function actionIndex()
    {
        $settingDate = Yii::$app->db->createCommand('SELECT * FROM {{%setting}}')->queryAll();
        $settings = ArrayHelper::map($settingDate, 'key', 'value');

        if (($post = Yii::$app->request->post())) {
            unset($post['_csrf']);
            if (Yii::$app->setting->set($post)) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
            } else {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Error'));
            }
            return $this->refresh();
        }

        return $this->render('index', [
            'settings' => $settings,
        ]);
    }

    /**
     * Displays a single Setting model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Setting model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Setting();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->key]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Setting model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->key]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Setting model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionSendUrl(){

        $model = new SendUrlToUser();

        if($model->load(Yii::$app->request->post())){

            $address_1 = array('province1'=>urlencode(Yii::$app->request->post('province1')),'city1'=>urlencode(Yii::$app->request->post('city1')));
            $address = $address_1;

            $address_2 = array('province2'=>urlencode(Yii::$app->request->post('province2')),'city2'=>urlencode(Yii::$app->request->post('city2')));
            if(!empty(array_filter($address_2))){
                $address = array_merge($address,$address_2);
            }

            $address_3 = array('province3'=>urlencode(Yii::$app->request->post('province3')),'city3'=>urlencode(Yii::$app->request->post('city3')));
            if(!empty(array_filter($address_3))){
                $address = array_merge($address,$address_3);
            }

            $model->rand = md5(time().rand(1000,9999));

            $model->url = urldecode(json_encode($address));

            $url = "http://13loveme.com/signup?type=";

            if($model->save()){

                $data_arr = array('description'=>"生成一个网站会员注册链接",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);

                return $this->render('url',['model'=>$model,'url'=>$url]);
            }
        }

        return $this->render('send_url',['model'=>$model]);
    }


    public function actionSendCollectingUrl(){

        $model = new CollectingFilesText();
        $query = (new Query())->select('flop_id,area')->from('pre_flop_content')->where(['not in','area',['精选汉子','优质','女生档案']])->all();
        $area = ArrayHelper::map($query,'flop_id','area');
        if($model->load(Yii::$app->request->post())){
            if(empty($model->address)){
                return '地区不可为空';
            }
            $model->flag = md5(time().md5(rand(10000,99999)));
            $model->flop_id = $model->address;
            $model->address = $area[$model->address];
            if(!empty($model::findOne(['id'=>$model->id]))){
                return '该会员编号已经存在,新入会会员无需填写由系统自动生成，老会员可<a href="/index.php/collecting-file/thirth-files" style="color:red;" target="_blank">点击此处</a>进行编号查询后发送链接给会员，如果此编号名花无主，可随机分配给会员，客服人员在微信端备注即可！';
            }

            if($model->save()){
                $data_arr = array('description'=>"生成一个十三普通会员信息收集链接",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);
                $url = "http://13loveme.com/files/";
                return $this->render('send-collecting-url',['model'=>$model,'url'=>$url]);
            }
        }
        return $this->render('_collecting_url',['model'=>$model,'areas'=>$area]);

    }


    public function actionSendCollectingSeventeenUrl(){

        $model = new CollectingSeventeenFilesText();

        if($model->load(Yii::$app->request->post())){

            $model->flag = md5(time().md5(rand(100000,999999)));
            if($model->save()){

                $data_arr = array('description'=>"生成一个十七平台女生会员信息收集链接",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);

                $url = "http://13loveme.com/17-files/";
                return $this->render('send-collecting-seventeen-url',['model'=>$model,'url'=>$url]);
            }
        }
        return $this->render('_collecting_seventeen_url',['model'=>$model]);
    }

    public function actionSendSeventeenManUrl(){

        $model = new SeventeenWeiUser();

        if($model->load(Yii::$app->request->post())){

            $model->flag = md5(time().md5(rand(100000,999999)));
            if($model->save()){

                $data_arr = array('description'=>"生成一个十七平台男生会员链接",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);
                $url = "http://13loveme.com/wei-xin/seventeen-code";
                return $this->render('send-seventeen-man-url',['model'=>$model,'url'=>$url]);
            }else{

                return var_dump($model->errors);
            }
        }
        return $this->render('_seventeen_man_url',['model'=>$model]);
    }

    public function actionVipTemp(){

        $data = Yii::$app->request->get();

        if(!empty($data)){

            $user_id = User::getId($data['number']);
            $tempModel = new UserVipTempAdjust();
            if(!empty($user_id)){

                $user_vip = User::getVip($user_id);
                if($user_vip<$data['vip']){
                    if(empty($tempModel::findOne(['user_id'=>$user_id]))){
                        $tempModel->user_id = $user_id;
                        $tempModel->vip = $data['vip'];
                        if($tempModel->save()){
                            Yii::$app->db->createCommand("update {{%user}} set groupid = {$data['vip']} where id={$user_id}")->execute();
                            Yii::$app->db->createCommand("update {{%user_data}} set jiecao_coin = jiecao_coin+$data[coin] where user_id={$user_id}")->execute();
                            Yii::$app->session->setFlash('success','添加试用包成功');
                        }
                    }else{
                        Yii::$app->session->setFlash('warning',$data['number'].'--已经使用过了');
                    }

                }else{

                    Yii::$app->session->setFlash('warning',$data['number'].'--该会员等级比试用包高');
                }

            }else{

                Yii::$app->session->setFlash('warning',$data['number'].'--该会员不存在');
            }
            return $this->redirect('vip-temp');

        }
        return $this->render('vip-temp');

    }
    public function actionVipTempTj(){

        $model = UserVipTempAdjust::find()->orderBy('created_at desc')->asArray()->all();
        return $this->render('vip-temp-tj',['model'=>$model]);

    }
    /**
     * Finds the Setting model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return Setting the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Setting::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
