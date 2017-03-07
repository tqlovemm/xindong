<?php

namespace backend\modules\bgadmin\controllers;

use backend\components\AddRecord;
use backend\modules\bgadmin\models\SmadminMemberFiles;
use backend\modules\bgadmin\models\SmadminMemberText;
use Yii;
use backend\modules\bgadmin\models\SmadminMember;
use backend\modules\bgadmin\models\SmadminMemberSearch;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
/**
 * DefaultController implements the CRUD actions for SmadminMember model.
 */
class SmDefaultController extends Controller
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
     * Lists all SmadminMember models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SmadminMemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionActiveRecord(){

        $model = new SmadminMemberText();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            if($model->type==0){
                $to = 'view';
            }elseif ($model->type==1){
                $to = 'view-photo';
            }elseif ($model->type==2){
                $to = 'view-pay';
            }elseif ($model->type==3){
                $to = 'view-chat';
            }elseif ($model->type==5){
                $to = 'view-flop';
            }elseif ($model->type==6){
                $to = 'view-dating';
            }elseif ($model->type==7){
                $to = 'view-feedback';
            }else{
                $to = 'view-other';
            }
            return $this->redirect([$to, 'id' => $model->member_id]);

        } else {
            return $this->render('active-record', [
                'model' => $model,
            ]);
        }

    }
    /**
     * Displays a single SmadminMember model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id){
       return $this->getData($id,'view',0);
    }
    public function actionViewPhoto($id){
        return $this->getData($id,'view-photo',1);
    }
    public function actionViewPay($id){
        return $this->getData($id,'view-pay',2);
    }
    public function actionViewChat($id){
        return $this->getData($id,'view-chat',3);
    }
    public function actionViewFlop($id){
        return $this->getData($id,'view-flop',5);
    }
    public function actionViewDating($id){
        return $this->getData($id,'view-dating',6);
    }
    public function actionViewFeedback($id){
        return $this->getData($id,'view-feedback',7);
    }
    public function actionViewOther($id){
        return $this->getData($id,'view-other',8);
    }

    protected function getData($id,$view,$num){

        $model = $this->findModel($id);
        $weima = $model->getMemberText($num);
        $record = SmadminMemberText::find()->where(['member_id'=>$id,'type'=>$num])->count();
        $count = $weima->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => '20']);

        $imgs = SmadminMemberFiles::find()->where(['member_id'=>$id,'img_type'=>$num])->orderBy('created_at desc');

        $count2 = $imgs->count();
        $pagination2 = new Pagination(['totalCount' => $count2, 'pageSize' => '15']);

        $weimas = $weima->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        $query = $imgs->offset($pagination2->offset)
            ->limit($pagination2->limit)
            ->all();


        return $this->render($view, [
            'model' => $model,
            'weimas'=>$weimas,
            'pagination'=>$pagination,
            'imgs'=>$query,
            'count'=>$count,
            'pagination2'=>$pagination2,
            'record'=>$record,
        ]);

    }

    public function actionUpdateImg($id){

        $model = SmadminMemberFiles::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);
            if($model->update()){
                $data_arr = array('description'=>"修改西檬之家会员跟踪信息一条记录图片信息，图片ID:{$id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            Yii::$app->getSession()->setFlash('success','保存成功');
        }
        return $this->render('update-img', [
            'model' => $model,
        ]);
    }

    public function actionUpdateText($id){

        $model = SmadminMemberText::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);
            if($model->update()){
                $data_arr = array('description'=>"修改西檬之家会员跟踪信息一条记录，会员ID:{$model->member_id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            Yii::$app->getSession()->setFlash('success','保存成功');
        }
        return $this->render('update-text', [
            'model' => $model,
        ]);
    }

    public function actionDeleteImg($id){

        $model = SmadminMemberFiles::findOne($id);
        $str = substr($model->path,1,strlen($model->path));
        if(Yii::$app->user->id==10000){
            if($model->delete()){

                $data_arr = array('description'=>"删除西檬之家会员跟踪信息一张图片",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
                AddRecord::record($data_arr);

                @unlink($str);
                $back_url = Yii::$app->request->referrer;
                return $this->redirect($back_url);
            }
        }else{
            throw new ForbiddenHttpException('禁止操作');
        }

    }
    public function actionDeleteText($id){

        $model = SmadminMemberText::findOne($id);

        $imgs = $model->memberFiles;

        if(Yii::$app->user->id==10000){

            if($model->delete()){

                $data_arr = array('description'=>"删除西檬之家会员跟踪信息一个记录",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
                AddRecord::record($data_arr);

                foreach ($imgs as $list){
                    $str = substr($list->path,1,strlen($list->path));
                    @unlink($str);
                }
                $back_url = Yii::$app->request->referrer;
                return $this->redirect($back_url);
            }
        }else{
            throw new ForbiddenHttpException('禁止操作');
        }

    }

    public function actionUpload($id){

        $model = SmadminMemberText::findOne($id);
        if (Yii::$app->request->isPost) {
            $upload = $model->upload();
            if($upload){
                $data_arr = array('description'=>"为会员跟踪信息上传一张图片,会员ID：{$upload->member_id},图片链接：<img style='width: 80px;' src={$upload->path}>",'data'=>json_encode($upload),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);
            }
        }

        return $this->render('upload', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new SmadminMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SmadminMember();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $data_arr = array('description'=>"创建一个西檬之家后台跟踪会员信息,会员编号：{$model->number}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
            AddRecord::record($data_arr);
            return $this->redirect(['view', 'id' => $model->member_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing SmadminMember model.
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
                $data_arr = array('description'=>"修改一个西檬之家后台跟踪会员信息,会员编号：{$model->number}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            return $this->redirect(['view', 'id' => $model->member_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing SmadminMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if(Yii::$app->user->id==10000){
            $model = $this->findModel($id);
            if($model->delete()){
                $data_arr = array('description'=>"删除一个西檬之家后台跟踪会员信息,会员编号：{$model->number}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
                AddRecord::record($data_arr);
            }
        }else{
            throw new ForbiddenHttpException('禁止操作');
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the SmadminMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SmadminMember the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SmadminMember::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
