<?php

namespace backend\modules\exciting\controllers;

use backend\modules\bgadmin\models\BgadminGirlMember;
use backend\modules\sm\models\Province;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\ForbiddenHttpException;
use backend\modules\exciting\models\OtherTextPic;
use backend\modules\exciting\models\OtherTextPicSearch;
/**
 * OtherTextPicController implements the CRUD actions for OtherTextPic model.
 */
class OtherTextPicController extends Controller
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
     * Lists all OtherTextPic models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OtherTextPicSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single OtherTextPic model.
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
     * Creates a new OtherTextPic model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new OtherTextPic();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pid]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing OtherTextPic model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
 /*       $bgadmin = BgadminGirlMember::find();
        $query = ArrayHelper::map($bgadmin->select('address_a')->where(['sex'=>0])->asArray()->all(),'address_a','address_a');
        unset($query['优质'],$query['女生档案']);
        $area = array_filter($query);*/
        $area = ArrayHelper::map(Province::find()->select("prov_name")->orderBy('prov_py asc')->all(),'prov_name','prov_name');
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->pid]);
        } else {
            return $this->render('update', [
                'model' => $model,'area'=>$area
            ]);
        }
    }
    public function actionCreateBg($pid){

        $model = OtherTextPic::findOne($pid);
        $number = $model->number;
        $r = BgadminGirlMember::findOne(['number'=>$number]);
        $member = empty($r)?BgadminGirlMember::findOne(['number'=>substr($number,0,strlen($number)-2)]):$r;
        if(empty($member)){
            return '不存在该女生，请私人客服及时建立女生资料上传二维码';
        }
        return $this->redirect('/bgadmin/girl-default/view?id='.$member->member_id);
    }

    /**
     * Deletes an existing OtherTextPic model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect('index');
    }

    /**
     * @param $id
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     * Finds the OtherTextPic model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @return OtherTextPic the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = OtherTextPic::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
