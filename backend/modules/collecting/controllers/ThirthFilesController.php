<?php

namespace backend\modules\collecting\controllers;

use backend\components\AddRecord;
use backend\models\CollectingFilesText;
use backend\modules\bgadmin\models\BgadminMember;
use backend\modules\flop\models\FlopContent;
use frontend\models\CollectingFilesImg;
use Imagine\Test\Filter\Basic\ResizeTest;
use Yii;
use backend\models\ThirthFiles;
use backend\modules\collecting\models\ThirthFilesSearch;
use yii\base\Exception;
use yii\base\Object;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ThirthFilesController implements the CRUD actions for ThirthFiles model.
 */
class ThirthFilesController extends Controller
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
     * Lists all ThirthFiles models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ThirthFilesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionHaveNoFile(){
        $model = new ThirthFiles();

        $model = $model::find()->select('id')->asArray()->all();
        $query = (new Query())->select('number')->from('pre_flop_content')->where(['is_cover'=>1])->all();
        $data_1 = ArrayHelper::map($model,'id','id');
        $data_2 = ArrayHelper::map($query,'number','number');

        $data = array_intersect($data_1,$data_2);

        $diff = array_diff($data_1,$data);

        return $this->render('no-files',['diff'=>$diff]);

    }

    public function actionHaveNoFlop(){

        $flop = ArrayHelper::map(FlopContent::find()->select('number')->asArray()->all(),'number','number');
        $bgadmin = ArrayHelper::map(BgadminMember::find()->select('number')->asArray()->all(),'number','number');
        $data = array_intersect($flop,$bgadmin);
        $diff = array_diff($flop,$data);

        return $this->render('no-bgadmin',['diff'=>$diff]);
    }

    public function actionHaveNoFollow(){

        $flop = ArrayHelper::map(\frontend\models\CollectingFilesText::find()->select('id')->where(['status'=>2])->asArray()->all(),'id','id');
        $bgadmin = ArrayHelper::map(BgadminMember::find()->select('number')->asArray()->all(),'number','number');
        $data = array_intersect($flop,$bgadmin);
        $diff = array_diff($flop,$data);

        return $this->render('no-bgadmin',['diff'=>$diff]);
    }

    /**
     * Displays a single ThirthFiles model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $img = CollectingFilesImg::find()->where(['text_id'=>$id])->asArray()->all();
        return $this->render('view', [
            'model' => $this->findModel($id),
            'img'=>$img,
        ]);
    }

    /**
     * Creates a new ThirthFiles model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ThirthFiles();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ThirthFiles model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $query = FlopContent::find()->select('flop_id,area')->where(['not in','area',['精选汉子','优质','女生档案']])->asArray()->all();
        //$query = (new Query())->select('flop_id,area')->from('pre_flop_content')->where(['not in','area',['精选汉子','优质','女生档案']])->all();
        $area = ArrayHelper::map($query,'flop_id','area');

        $flop_id2 = $model->flop_id2;
        $flop_id3 = $model->flop_id3;

        if ($model->load(Yii::$app->request->post())) {

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            $model->address = $area[$model->flop_id];
            $data_arr = array('description'=>"修改十三普通会员{$model->id}的档案",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
            AddRecord::record($data_arr);

            if($model->update()){

                if($model->flop_id2!=0){

                    $ex = FlopContent::findOne(['number'=>$id,'flop_id'=>$flop_id2]);
                    if(!empty($ex)){
                        $ex->delete();
                    }
                    $this->saveToFlop($id,$model,$area,2);

                }else{
                    $ex2 = FlopContent::findOne(['number'=>$id,'flop_id'=>$flop_id2]);
                    if(!empty($ex2)){
                        $ex2->delete();
                    }
                }

                if($model->flop_id3!=0){
                    $ex = FlopContent::findOne(['number'=>$id,'flop_id'=>$flop_id3]);
                    if(!empty($ex)){
                        $ex->delete();
                    }
                    $this->saveToFlop($id,$model,$area,3);
                }else{
                    $ex2 = FlopContent::findOne(['number'=>$id,'flop_id'=>$flop_id3]);
                    if(!empty($ex2)){
                        $ex2->delete();
                    }
                }



            }

            return $this->redirect(['view', 'id' => $model->id]);

        } else {
            return $this->render('update', [
                'model' => $model,'areas'=>$area,
            ]);
        }
    }

    protected function saveToFlop($id,$model,$area,$n){

        $flop_id = 'flop_id'.$n;
        try{
            $flop = FlopContent::findOne(['number'=>$id,'flop_id'=>$model->$flop_id]);
            if(!empty($flop)){
                $flop->delete();
            }

        }catch (Exception $e){

            throw new Exception($e);
        }

        $insert_flop = new FlopContent();
        $insert_flop->area = $area[$model->$flop_id];
        $insert_flop->flop_id = $model->$flop_id;
        $insert_flop->created_at = time();
        $insert_flop->created_by = 10000;
        $insert_flop->number = $id;
        $insert_flop->is_cover = 1;
        $insert_flop->content = $insert_flop->path = $model->getCover();
        $insert_flop->save();

    }
    /**
     * Deletes an existing ThirthFiles model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        if($model->delete()){
            $data_arr = array('description'=>"删除十三普通会员{$model->id}的档案",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }

        return $this->redirect(['index']);
    }
    public function actionDeleteImg($id)
    {
        $model = CollectingFilesImg::findOne($id);

        if($model->delete()){
            $data_arr = array('description'=>"删除十三普通会员{$model->text_id}的一张生活照",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }

        $url = Yii::$app->request->referrer;
        return $this->redirect($url);
    }

    protected function insertBg($bg){

        $bgadmin = new BgadminMember();
        if(empty($bgadmin::findOne(['number'=>$bg->id]))){
            $bgadmin->number = "$bg->id";
            $bgadmin->address_a = $bg->address;
            $bgadmin->address_b = $bg->often_go;
            $bgadmin->weicaht = $bg->weichat;
            $bgadmin->weibo = $bg->weibo;
            $bgadmin->cellphone = $bg->cellphone;
            $bgadmin->time = date('Y-m-d',time());
            $bgadmin->sex = 0;
            $bgadmin->vip = $bg->vip;
            $bgadmin->coin = 60;
            $bgadmin->save();
        }
        return $bgadmin;
    }

    public function actionPass($id){

        $model = $this->findModel($id);
        $this->insertBg($model);
        $model->status = 2;
        $new = json_encode($model->attributes);
        $old = json_encode($model->oldAttributes);
        if($model->update()){
            try{
                $flop = FlopContent::findOne(['number'=>$id]);
                if(!empty($flop)){
                    $flop->delete();
                }
            }catch (Exception $e){
                throw new Exception($e);
            }

            $data_arr = array('description'=>"审核会员{$model->id}的档案通过",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
            AddRecord::record($data_arr);

            $insert_flop = new FlopContent();
            $insert_flop->area = $model->address;
            $insert_flop->flop_id = $model->flop_id;
            $insert_flop->created_at = time();
            $insert_flop->created_by = 10000;
            $insert_flop->number = $id;
            $insert_flop->is_cover = 1;
            $insert_flop->content = $insert_flop->path = $model->getCover();

            if($insert_flop->save()){
                return $this->redirect('index');
            }else{
                return var_dump($insert_flop->errors);
            }

        }else{
            return var_dump($model->errors);
        }
    }
    public function actionNoPass($id){

        $model = $this->findModel($id);

        $model->status = 3;
        $new = json_encode($model->attributes);
        $old = json_encode($model->oldAttributes);
        if($model->update()){

            $data_arr = array('description'=>"审核会员{$model->id}的档案不通过",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
            AddRecord::record($data_arr);
            return $this->redirect(['index']);

        }else{

            return var_dump($model->errors);
        }
    }

    /**
     * Finds the ThirthFiles model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ThirthFiles the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ThirthFiles::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
