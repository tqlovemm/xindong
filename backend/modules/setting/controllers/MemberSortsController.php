<?php

namespace backend\modules\setting\controllers;

use backend\components\AddRecord;
use common\Qiniu\QiniuUploader;
use frontend\modules\member\models\MemberSortImage;
use Yii;
use backend\modules\setting\models\MemberSorts;
use backend\modules\setting\models\MemberSortsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
/**
 * MemberSortsController implements the CRUD actions for MemberSorts model.
 */
class MemberSortsController extends Controller
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
        ];
    }

    /**
     * Lists all MemberSorts models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MemberSortsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MemberSorts model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionDeleteImg($id,$sort_id){

        $model = $this->findImgModel($id);
        if($model->delete()){
            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $qn->delete('threadimages',$model->img_path);
            return $this->redirect(['view','id'=>$sort_id]);
        }

    }
    public function actionSetImg($id){

        $model = $this->findImgModel($id);
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()){
                return $this->redirect(['view', 'id' => $model->sort_id]);
            }else{
                return var_dump($model->errors);
            }
        } else {
            return $this->render('set-img', [
                'model' => $model,
            ]);
        }
    }
    /**
     * Creates a new MemberSorts model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MemberSorts();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $data_arr = array('description'=>"创建会员等级种类，ID:{$model->id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
            AddRecord::record($data_arr);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
    /**
     * @param $id
     * @param string $type
     * @return string
     */
    public function actionUpload($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->upload();
        }
        return $this->render('upload', [
            'model' => $this->findModel($id),
        ]);
    }
    /**
     * Updates an existing MemberSorts model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            if($model->update()){
                $data_arr = array('description'=>"修改会员等级种类{$id}的资料信息",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }

            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MemberSorts model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){
            $data_arr = array('description'=>"删除会员等级种类，ID:{$id}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
            AddRecord::record($data_arr);
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the MemberSorts model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MemberSorts the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MemberSorts::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findImgModel($id)
    {
        if (($model = MemberSortImage::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
