<?php

namespace backend\modules\financial\controllers;

use backend\models\CollectingFilesText;
use backend\modules\financial\models\FinancialWechatMemberIncrease;
use backend\modules\financial\models\FinancialWechatPlatform;
use backend\modules\sm\models\Province;
use Yii;
use backend\modules\financial\models\FinancialWechatJoinRecord;
use backend\modules\financial\models\FinancialWechatJoinRecordSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\modules\financial\models\FinancialWechat;
/**
 * FinancialWechatJoinRecordController implements the CRUD actions for FinancialWechatJoinRecord model.
 */
class FinancialWechatJoinRecordController extends Controller
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
     * Lists all FinancialWechatJoinRecord models.
     * @return mixed d
     */
    public function actionIndex()
    {
        $searchModel = new FinancialWechatJoinRecordSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinancialWechatJoinRecord model.
     * @param integer $id
     * @param integer $wechat_id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionChoicePlatform(){

        return $this->render('choice-platform');

    }

    public function actionChoiceType($wechat_id){

        return $this->render('choice-type',['wechat_id'=>$wechat_id]);
    }

    /**
     * @param $wechat_id
     * @param string $type
     * @return string|void|\yii\web\Response
     * $query = Yii::$app->db->createCommand("select auto_increment from information_schema.`TABLES` where table_name='pre_collecting_files_text'")->queryScalar();
     * Creates a new FinancialWechatJoinRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($wechat_id,$type='')
    {
        $model = new FinancialWechatJoinRecord();
        $province = ArrayHelper::map(Province::find()->where(['prov_state'=>1])->orderBy('prov_py asc')->all(),'prov_name','prov_name');
        $platform = ArrayHelper::map(FinancialWechatPlatform::find()->all(),'platform_name','platform_name');

        $model->wechat_id = $wechat_id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $model->payment_screenshot = $model->upload();
            $model->type = $type;

            if($model->save()){

                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Saved successfully'));
                return $this->refresh();
            }else{

                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Error'));
                return var_dump($model->errors);
            }

        } else {

            return $this->render('create', [
                'model' => $model,'province'=>$province,'wechat_id'=>$wechat_id,'type'=>$type,'platform'=>$platform,
            ]);
        }
    }

    /**
     * Updates an existing FinancialWechatJoinRecord model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param integer $wechat_id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $platform = ArrayHelper::map(FinancialWechatPlatform::find()->all(),'platform_name','platform_name');
        $wechat = ArrayHelper::map(FinancialWechat::findAll(['status'=>10]),'id','wechat');
        $province = ArrayHelper::map(Province::find()->where(['prov_state'=>1])->orderBy('prov_py asc')->all(),'prov_name','prov_name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('/financial/financial-wechat/everyday-fee-record');
        } else {
            return $this->render('update', [
                'model' => $model,'wechat'=>$wechat,'province'=>$province,'platform'=>$platform,
            ]);
        }
    }

    /**
     * Deletes an existing FinancialWechatJoinRecord model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param integer $wechat_id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = 0;
        $model->update();
        return $this->redirect(['index']);
    }

    /**
     * Finds the FinancialWechatJoinRecord model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param integer $wechat_id
     * @return FinancialWechatJoinRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinancialWechatJoinRecord::findOne(['id' => $id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
