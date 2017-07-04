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
            if($cid){
                if($status == 1){
                    $content = "恭喜您！您的视频认证已通过了~";
                }elseif($status == 2){
                    $content = "很抱歉！您的视频认证未通过，请重新认证！";
                }
                $title = $content;
                $msg = $content;
                $date = time();
                //$icon = Yii::$app->params['icon'].'/images/app_push/u=2285230243,2436417019&fm=21&gp=0.png';
                $icon = "";
                $extras = json_encode(array('push_title'=>urlencode($title),'push_content'=>urlencode($msg),'push_type'=>'SSCOMM_NOTICE'));
                Yii::$app->db->createCommand("insert into {{%app_push}} (type,status,cid,title,msg,extras,platform,response,icon,created_at,updated_at) values('SSCOMM_NOTICE',2,'$cid','$title','$msg','$extras','all','NULL','$icon',$date,$date)")->execute();
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
