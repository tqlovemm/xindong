<?php

namespace backend\modules\bgadmin\controllers;

use app\components\SaveToLog;
use backend\components\AddRecord;
use backend\models\User;
use backend\modules\bgadmin\models\BgadminGirlMemberFiles;
use backend\modules\bgadmin\models\BgadminMemberFlop;
use backend\modules\bgadmin\models\BgadminGirlMemberText;
use backend\modules\bgadmin\models\ScanWeimaDetail;
use backend\modules\dating\models\Dating;
use backend\modules\dating\models\DatingContent;
use backend\modules\dating\models\DatingSignup;
use backend\modules\flop\models\FlopContent;
use backend\modules\seek\models\GirlNumberRecord;
use backend\modules\sm\models\Province;
use backend\modules\weekly\models\Weekly;
use backend\modules\weekly\models\WeeklyContent;
use frontend\models\CollectingFilesText;
use Imagine\Test\Filter\Basic\ResizeTest;
use Yii;
use backend\modules\bgadmin\models\BgadminGirlMember;
use backend\modules\bgadmin\models\BgadminGirlMemberSearch;
use yii\helpers\ArrayHelper;
use yii\myhelper\Random;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\Pagination;
/**
 * GirlDefaultController implements the CRUD actions for BgadminGirlMember model.
 */
class GirlDefaultController extends Controller
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
     * Lists all BgadminGirlMember models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new BgadminGirlMemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionSendGirlUrl(){

        $rand = md5(mt_rand(100,999));
        $weekly = new Weekly();
        $weekly->title = "null";
        $weekly->content = "null";
        $weekly->url = "null";
        $weekly->flag = $rand;
        $weekly->cover_id = -2;
        $weekly->status = 2;
        $weekly->save();
        return $this->render('send-girl-url',['model'=>$weekly]);
    }

    public function actionActiveRecord(){

        $model = new BgadminGirlMemberText();

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
     * Displays a single BgadminGirlMember model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id){
       return $this->getData($id,'view',0);
    }

    /**
     * @param $id
     * @param $mid
     * @return string
     * 档案照
     */
    public function actionViewFile($id,$mid){
        $model = $this->findModel($mid);
        $file = ($model->sex==0)? CollectingFilesText::findOne($id):Dating::findOne(['number'=>$id.$model->fantasies.$model->credit]);
        if(!empty($file)){
            $imgs = ($model->sex==0)? $file->imgs:$file->photos;
            return $this->render('view-file',['file'=>$file,'imgs'=>$imgs,'model'=>$model]);
        }
        return $this->render('view-file',['model'=>$model]);
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

    /**
     * @param $id
     * @return string|void
     * 翻牌记录
     */
    public function actionViewFlop($id){
        $flop = new BgadminMemberFlop();
        $model = $this->findModel($id);
        if($model->sex==0) {
            $data = $flop::find()->select('floping_number,created_at,created_by')->where(['floped_number'=>$model->number]);
            $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
            $flops = $data->offset($pages->offset)->limit($pages->limit)->all();
        }else{
            $data = $flop::find()->select('floped_number,created_at,created_by')->where(['floping_number'=>$model->number]);
            $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
            $flops = $data->offset($pages->offset)->limit($pages->limit)->all();
        }
        return $this->render('view-flop',['model'=>$model,'flops'=>$flops,'pages' => $pages,]);
    }

    /**
     * @param $id
     * @return string
     */
    public function actionDetail($id,$type){
        $this->layout = '/other';
        if($type==1){
            $date = Dating::findOne(['number'=>$id]);
            return $this->render('detail',['date'=>$date,'photos'=>$date->photos]);
        }else{
            $date = CollectingFilesText::findOne($id);
            if(empty($date)){
                return '暂无档案数据';
            }
            return $this->render('detail',['date'=>$date,'photos'=>$date->imgs]);
        }
    }

    /**
     * @param $id
     * @return string
     */
    public function actionViewDating($id){

        $model = $this->findModel($id);

        if($model->sex==0){
            $user_id = User::getId($model->number);
            if(!empty($user_id)){
                $data = DatingSignup::find()->where(['user_id'=>$user_id]);
                $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
                $flops = $data->offset($pages->offset)->limit($pages->limit)->all();
            }else{
                return '该会员还未注册成为网站会员，所以还没有网站密约记录';
            }
        }else{
            $data = DatingSignup::find()->where(['like_id'=>$model->number]);
            $pages = new Pagination(['totalCount' =>$data->count(), 'pageSize' => '20']);
            $flops = $data->offset($pages->offset)->limit($pages->limit)->all();
        }
        return $this->render('view-dating',['model'=>$model,'flops'=>$flops,'pages' => $pages,]);

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
        $record = BgadminGirlMemberText::find()->where(['member_id'=>$id,'type'=>$num])->count();
        $count = $weima->count();
        $pagination = new Pagination(['totalCount' => $count, 'pageSize' => '20']);

        $imgs = BgadminGirlMemberFiles::find()->where(['member_id'=>$id,'img_type'=>$num])->orderBy('created_at desc');

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

        $model = BgadminGirlMemberFiles::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);
            if($model->update()){
                $data_arr = array('description'=>"修改十三平台会员跟踪信息一条记录图片信息，图片ID:{$id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            Yii::$app->getSession()->setFlash('success','保存成功');
        }
        return $this->render('update-img', [
            'model' => $model,
        ]);
    }

    public function actionUpdateText($id){

        $model = BgadminGirlMemberText::findOne($id);
        if ($model->load(Yii::$app->request->post())) {
            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);
            if($model->update()){
                $data_arr = array('description'=>"修改十三平台会员跟踪信息一条记录，会员ID:{$model->member_id}",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
            }
            Yii::$app->getSession()->setFlash('success','保存成功');
        }
        return $this->render('update-text', [
            'model' => $model,
        ]);
    }

    public function actionDeleteImg($id){

        $model = BgadminGirlMemberFiles::findOne($id);
        $str = substr($model->path,1,strlen($model->path));
        if($model->delete()){

            $data_arr = array('description'=>"删除十三平台会员跟踪信息一张图片",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);

            @unlink($str);
            $back_url = Yii::$app->request->referrer;
            return $this->redirect($back_url);
        }
    }
    public function actionDeleteText($id){

        $model = BgadminGirlMemberText::findOne($id);

        $imgs = $model->memberFiles;



            if($model->delete()){

                $data_arr = array('description'=>"删除十三平台会员跟踪信息一个记录",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
                AddRecord::record($data_arr);

                foreach ($imgs as $list){
                    $str = substr($list->path,1,strlen($list->path));
                    @unlink($str);
                }
                $back_url = Yii::$app->request->referrer;
                return $this->redirect($back_url);
            }

    }

    public function actionUpload($id){

        $model = BgadminGirlMemberText::findOne($id);
        if (Yii::$app->request->isPost) {
            $upload = $model->upload();
            if($upload){
                $data_arr = array('description'=>"为十三平台会员跟踪信息上传一张图片,会员ID：{$upload->member_id},图片链接：<img style='width: 80px;' src={$upload->path}>",'data'=>json_encode($upload),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);
            }
        }

        return $this->render('upload', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new BgadminGirlMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BgadminGirlMember();
        if ($model->load(Yii::$app->request->post())) {
                $model->flag = md5(time().mt_rand(100,999));
                $newNumber = $model->number.$model->fantasies.$model->credit;
                if($model->save()){
                    $girlNumberRecord = new GirlNumberRecord();
                    $girlNumberRecord->number = $newNumber;
                    if($girlNumberRecord->save()){
                        $dating = new Dating();
                        if(empty($dating::findOne(['number'=>$newNumber]))){
                            $dating->number = $newNumber;
                            $dating->title = $model->address_a;
                            $dating->content = $model->address_a.'妹子';
                            $dating->url = '帅哥';
                            $dating->expire = 48;
                            $dating->sort = 1;
                            $dating->cover_id = -2;
                            $dating->worth = $model->coin;
                            $dating->flag = $model->flag;
                            $dating->save();
                        }
                    }

                }else{

                    $area = ArrayHelper::map(Province::find()->select('prov_name')->orderBy('prov_py asc')->all(),'prov_name','prov_name');
                    return $this->render('create', [
                        'model' => $model,'area'=>$area
                    ]);
                }
            return $this->redirect(['view', 'id' => $model->member_id]);

        } else {
            $area = ArrayHelper::map(Province::find()->select('prov_name')->orderBy('prov_py asc')->all(),'prov_name','prov_name');
            return $this->render('create', [
                'model' => $model,'area'=>$area
            ]);
        }
    }

    public function getNumber(){

        $number = $this->numberTime().$this->numberRang();
        return $number;
    }

    protected function numberTime(){

        $year = date('y',time());
        $month = date('m',time());
        $day = date('d',time());
        return $this->numberBeforeTime($year).$this->numberBeforeTime($month).$this->numberBeforeTime($day);
    }

    protected function numberRang(){

        $model = GirlNumberRecord::find()->where(['updated_at'=>strtotime('today')])->count()+1;
        if($model<10){
            return '0'.$model;
        }
        return $model;
    }

    protected function numberBeforeTime($time){

        $data = [
            '01'=>'Q','02'=>'W','03'=>'E','04'=>'R','05'=>'T','06'=>'Y','07'=>'U','08'=>'I','09'=>'O','10'=>'P',
            '11'=>'A','12'=>'S','13'=>'D','14'=>'F','15'=>'G','16'=>'H','17'=>'J','18'=>'K','19'=>'L',
            '20'=>'Z','21'=>'X','22'=>'C','23'=>'V','24'=>'B','25'=>'N','26'=>'M','27'=>'72',
            '28'=>'EP','29'=>'WP','30'=>'QP','31'=>'13'
        ];

        return $data[$time];
    }

    public function actionGetGirlNumber(){

        $number = $this->numberTime().$this->numberRang();
        return $number;
    }
    /**
     * Updates an existing BgadminGirlMember model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post())) {
            $newNumber = $model->number.$model->fantasies.$model->credit;
            if($model->update()){
                $weekly = Weekly::findOne(['flag'=>$model->flag]);

                if(!empty($weekly)){

                    if(empty($weekly->number)){

                        $girlNumberRecord = new GirlNumberRecord();
                        if(empty($girlNumberRecord::findOne(['number'=>$newNumber]))){
                            $girlNumberRecord->number = $newNumber;
                            $girlNumberRecord->save();
                        }
                        $weekly->number = $newNumber;
                        $weekly->worth = $model->coin;
                        $weekly->title = $model->address_a;
                        $weekly->platform = $model->foreign;
                        if($weekly->update()){
                            $textModel = new BgadminGirlMemberText();
                            $textModel->member_id =$id;
                            $textModel->type =0;
                            if($textModel->save()){
                                $fileModel = new BgadminGirlMemberFiles();
                                $fileModel->member_id = $id;
                                $fileModel->text_id = $textModel->text_id;
                                $fileModel->path = WeeklyContent::findOne(['album_id'=>$weekly->id,'status'=>2])->path;
                                if(!$fileModel->save()){
                                    return var_dump($fileModel->errors);
                                }
                            }
                        }
                    }

                    if(($weekly->number != $newNumber)||($weekly->title != $model->address_a)||($weekly->platform != $model->foreign)){
                        $weekly->number = $newNumber;
                        $weekly->worth = $model->coin;
                        $weekly->title = $model->address_a;
                        $weekly->platform = $model->foreign;
                        if(!$weekly->update()){
                            return var_dump($weekly->errors);
                        }
                    }

                }

            }
            return $this->redirect(['view', 'id' => $model->member_id]);
        } else {
            $area = ArrayHelper::map(Province::find()->select('prov_name')->orderBy('prov_py asc')->all(),'prov_name','prov_name');
            return $this->render('update', [
                'model' => $model,'area'=>$area
            ]);
        }
    }

    /**
     * Deletes an existing BgadminGirlMember model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

            $model = $this->findModel($id);
            if($model->delete()){
                $data_arr = array('description'=>"删除一个十三平台后台跟踪会员信息,会员编号：{$model->number}",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
                AddRecord::record($data_arr);
            }

        return $this->redirect(['index']);
    }

    /**
     * Finds the BgadminGirlMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BgadminGirlMember the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BgadminGirlMember::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
