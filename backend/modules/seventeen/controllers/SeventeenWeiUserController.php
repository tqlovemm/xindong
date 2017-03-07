<?php

namespace backend\modules\seventeen\controllers;

use backend\components\AddRecord;
use Yii;
use backend\modules\seventeen\models\SeventeenWeiUser;
use backend\modules\seventeen\models\SeventeenWeiUserSearch;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SeventeenWeiUserController implements the CRUD actions for SeventeenWeiUser model.
 */
class SeventeenWeiUserController extends Controller
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
     * Lists all SeventeenWeiUser models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SeventeenWeiUserSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SeventeenWeiUser model.
     * @param integer $id
     * @param string $openid
     * @return mixed
     */
    public function actionView($id, $openid)
    {
        return $this->render('view', [
            'model' => $this->findModel($id, $openid),
        ]);
    }

    /**
     * Creates a new SeventeenWeiUser model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SeventeenWeiUser();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id, 'openid' => $model->openid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SeventeenWeiUser model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @param string $openid
     * @return mixed
     */
    public function actionUpdate($id, $openid)
    {
        $model = $this->findModel($id, $openid);

        $query = (new Query())->select('id,address_province')->from('pre_collecting_17_files_text')->all();
        $area = array_unique(array_filter(ArrayHelper::map($query,'id','address_province')));
        $exist = array_filter(explode('，',$model->address));

        $area = array_diff($area,$exist);
        if ($model->load(Yii::$app->request->post())) {

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);
            if($model->update()){
                $data_arr = array('description'=>"修改十七平台男生会员信息，男生编号：{$id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            return $this->redirect(['view', 'id' => $model->id, 'openid' => $model->openid]);
        } else {
            return $this->render('update', [
                'model' => $model,'areas'=>$area,
            ]);
        }
    }

    /**
     * Deletes an existing SeventeenWeiUser model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @param string $openid
     * @return mixed
     */
    public function actionDelete($id, $openid)
    {
        $model = $this->findModel($id, $openid);
        if($model->delete()){
            $data_arr = array('description'=>"删除十七平台男生会员信息，男生编号：{$id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the SeventeenWeiUser model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @param string $openid
     * @return SeventeenWeiUser the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id, $openid)
    {
        if (($model = SeventeenWeiUser::findOne(['id' => $id, 'openid' => $openid])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
