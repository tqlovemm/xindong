<?php

namespace backend\modules\financial\controllers;

use backend\models\CollectingFilesText;
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
     * @return mixed
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
    public function actionView($id, $wechat_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $wechat_id),
        ]);
    }

    public function actionChoicePlatform(){

        return $this->render('choice-platform');

    }

    public function actionChoiceType($wechat_id){

        return $this->render('choice-type',['wechat_id'=>$wechat_id]);
    }

    /**
     * $query = Yii::$app->db->createCommand("select auto_increment from information_schema.`TABLES` where table_name='pre_collecting_files_text'")->queryScalar();
     * Creates a new FinancialWechatJoinRecord model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($wechat_id,$type='')
    {
        $model = new FinancialWechatJoinRecord();
        $province = ArrayHelper::map(Province::find()->where(['prov_state'=>1])->orderBy('prov_py asc')->all(),'prov_name','prov_name');

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            $model->wechat_id = $wechat_id;
            $model->payment_screenshot = $model->upload();
            $model->type = $type;
            if($model->save()){
                return $this->redirect(['index']);
            }else{
                return var_dump($model->errors);
            }

        } else {
            return $this->render('create', [
                'model' => $model,'province'=>$province,'wechat_id'=>$wechat_id,'type'=>$type
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
    public function actionUpdate($id, $wechat_id)
    {
        $model = $this->findModel($id, $wechat_id);
        $wechat = ArrayHelper::map(FinancialWechat::findAll(['status'=>10]),'id','wechat');
        $province = ArrayHelper::map(Province::find()->where(['prov_state'=>1])->orderBy('prov_py asc')->all(),'prov_name','prov_name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'wechat_id' => $model->wechat_id]);
        } else {
            return $this->render('update', [
                'model' => $model,'wechat'=>$wechat,'province'=>$province
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
    public function actionDelete($id, $wechat_id)
    {
        $this->findModel($id, $wechat_id)->delete();

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
    protected function findModel($id, $wechat_id)
    {
        if (($model = FinancialWechatJoinRecord::findOne(['id' => $id, 'wechat_id' => $wechat_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
