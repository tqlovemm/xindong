<?php

namespace backend\modules\app\controllers;

use backend\modules\app\models\AppSelfdating;
use backend\modules\app\models\UserData;
use backend\modules\app\models\UserImage;
use backend\modules\setting\models\AppPush;
use Yii;
use backend\modules\app\models\AppUserProfile;
use backend\modules\app\models\AppUserProfileSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AuditController implements the CRUD actions for AppUserProfile model.
 */
class AuditController extends Controller
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
     * Lists all AppUserProfile models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AppUserProfileSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single AppUserProfile model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = AppUserProfile::find()->where(['user_id'=>$id])->joinWith('user')->one();
        return $this->render('view', [
            'model' => $model,'images'=>$model->images,
        ]);
    }

    public function actionPass($id){

        $model = AppUserProfile::find()->where(['user_id'=>$id])->joinWith('user')->one();
        $model->app_nopass_msg = null;
        $model->status = 2;
        $model->flag = 2;
        $model->updated_at = time();
        if($model->update()){

            $option = array(
                'cid'=>$model->user->cid,
                'extra'=>"您的觅约信息提交已经通过审核，赶快开始你的觅约之旅吧。",
            );
            if($this->sendMsg($option)){
                return $this->redirect(['view','id'=>$id]);
            }
        }
    }

    public function actionNoPass($id,$extra){

        $model = AppUserProfile::find()->where(['user_id'=>$id])->joinWith('user')->one();
        $model->app_nopass_msg = $extra;
        $model->status = 3;
        $model->flag = 3;
        $model->updated_at = time();
        if($model->update()){
            //密约表格状态修改
            $self_dating = AppSelfdating::findOne(['user_id'=>$id,'status'=>0]);
            $self_dating->status = 1;
            $self_dating->updated_at = time();
            $self_dating->update();
            //用户数据表会员币退还
            $user_data = UserData::findOne($id);
            $user_data->jiecao_coin += $self_dating->pay;
            $user_data->update();

            $option = array(
                'cid'=>$model->user->cid,
                'extra'=>"对不起，您的觅约信息提交审核不通过，不通过原因：{$extra} ，退还心动币：{$self_dating->pay}。请重新提交。",
            );

            if($this->sendMsg($option)){
                return $this->redirect(['view','id'=>$id]);
            }
        }
    }

    /**
     * @param array $option
     * @return bool
     */
    protected function sendMsg($option=array()){

        $appPush = new AppPush();
        $appPush->cid = $option['cid'];
        $appPush->type = 'SSCOMM_NOTICE';
        $appPush->title = '觅约审核';
        $appPush->status = 2;
        $appPush->platform = 'all';
        $appPush->msg = $option['extra'];
        $appPush->extras = json_encode(array('push_title'=>urlencode($appPush->title),'push_content'=>urlencode($appPush->msg),'push_type'=>$appPush->type));
        $appPush->icon = 'http://admin.13loveme.com/images/app_push/u=2285230243,2436417019&fm=21&gp=0.png';

        if($appPush->save()){
            return true;
        }else{
            return false;
        }


    }

    /**
     * Creates a new AppUserProfile model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new AppUserProfile();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing AppUserProfile model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->user_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing AppUserProfile model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteImg($id)
    {

        $backUrl = Yii::$app->request->referrer;
        if(UserImage::findOne($id)->delete()){
            return $this->redirect($backUrl);
        }
    }

    /**
     * Finds the AppUserProfile model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return AppUserProfile the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = AppUserProfile::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
