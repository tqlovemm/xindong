<?php

namespace backend\modules\authentication\controllers;

use Yii;
use backend\modules\authentication\models\GirlAuthentication;
use backend\modules\authentication\models\GirlAuthenticationSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * GirlAuthenticationController implements the CRUD actions for GirlAuthentication model.
 */
class GirlAuthenticationController extends Controller
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
     * Lists all GirlAuthentication models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new GirlAuthenticationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single GirlAuthentication model.
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
     * Creates a new GirlAuthentication model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreate()
//    {
//        $model = new GirlAuthentication();
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * Updates an existing GirlAuthentication model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $status = $model->status;
            $userid = $model->user_id;
            $user = (new Query())->where(['id'=>$userid])->select('cid')->from('pre_user')->one();
            $cid = $user['cid'];
            if($cid && $status!=3){
                if($status == 1){
                    $content = "恭喜您！您的视频认证已通过了！";
                }elseif($status == 2){
                    //$content = Yii::$app->request->getBodyParam('beizhu');
                    $content = "您的认证视频因以下原因未通过：没有拍您本人，光线太暗看不清，或裸露身体或各种广告。请重新拍摄。";
                }
                $title = "视频验证";
                $msg = $content;
                $icon = Yii::$app->request->hostInfo.'/images/app_push/Group.png';
                $date = time();
                $weburl = Yii::$app->params['hostname']."/show.php?stype=".$status;
                $extras = json_encode(array('push_title'=>urlencode($title),'push_content'=>urlencode($msg),'push_type'=>'SSCOMM_AD_WEB','push_webTitle'=>urlencode($title),'push_webUrl'=>$weburl));
                Yii::$app->db->createCommand("insert into {{%app_push}} (type,status,cid,title,msg,extras,platform,response,icon,created_at,updated_at) values('SSCOMM_AD_WEB',2,'$cid','$title','$msg','$extras','all','NULL','$icon',$date,$date)")->execute();
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing GirlAuthentication model.
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
     * Finds the GirlAuthentication model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return GirlAuthentication the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = GirlAuthentication::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
