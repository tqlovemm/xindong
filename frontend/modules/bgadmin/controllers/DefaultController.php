<?php

namespace frontend\modules\bgadmin\controllers;

use backend\modules\bgadmin\models\BgadminGirlMember;
use backend\modules\setting\models\AuthAssignment;
use common\models\Province;
use backend\modules\weekly\models\Weekly;
use backend\modules\weekly\models\WeeklyContent;
use common\Qiniu\QiniuUploader;
use frontend\modules\bgadmin\models\UserMark;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
class DefaultController extends Controller
{
    public $layout = '/basic';

    public  $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['change-file','send-collection-url'],
                'rules' => [
                    [
                        'actions' => ['change-file','send-collection-url'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex($flag=null){

        $model = new Weekly();
        $query = $model::find()->where(['flag'=>$flag])->asArray()->one();
        $area = ArrayHelper::map(Province::find()->select('prov_name')->orderBy('prov_py asc')->all(),'prov_name','prov_name');

        try{
            $weekContentModel = WeeklyContent::find();
            $img = $weekContentModel->where(['album_id'=>$query['id']])->andWhere(['status'=>0])->asArray()->all();
            $weima = $weekContentModel->where(['album_id'=>$query['id']])->andWhere(['status'=>2])->asArray()->one();

        }catch (\Exception $e){
            throw new ForbiddenHttpException('非法访问');
        }
        $mark = array_filter(ArrayHelper::map(UserMark::find()->select('make_friend_name')->asArray()->all(),'make_friend_name','make_friend_name'));
        if(!empty($query)){
            if(in_array($query['enable_comment'],[2,3])){
                return $this->render('success');
               // return $this->render('index-message',['queries'=>$query,'img'=>$img]);
            }
            return $this->render('index',['queries'=>$query,'img'=>$img,'area'=>$area,'weima'=>$weima,'marks'=>$mark]);
        }
    }

    public function actionIndexMessage(){

        return $this->render('index');
    }

    public function actionText($id){

        $postData = $_POST;
        $model = $this->findModel($id);

        if(in_array($model['enable_comment'],[2,3])){
            throw new ForbiddenHttpException('无效链接');
        }

        $model->title = $postData['title'];
        $model->title2 = isset($postData['title2'])?$postData['title2']:"null";
        $model->title3 = isset($postData['title3'])?$postData['title3']:"null";
        $model->content = $postData['title'].'妹子，'.$postData['age'].'岁，'.$postData['height'].'cm';
        $model->url = $postData['mark_friend_label'];
        $model->worth = 50;
        $model->status = 2;
        $model->enable_comment = 2;
        $model->avatar = WeeklyContent::findOne(['album_id'=>$model->id,'status'=>0])->path;
        /*foreach ($_POST as $key=>$list){
            $model->$key = $list;
        }
         $model->weichat = Yii::$app->request->post('weichat');
         $model->weibo = Yii::$app->request->post('weibo');
         $model->email = Yii::$app->request->post('email');
         $model->qq = Yii::$app->request->post('qq');
         $model->cellphone = Yii::$app->request->post('cellphone');
         $model->birthday = Yii::$app->request->post('birthday');
         $model->height = Yii::$app->request->post('height');
         $model->weight = Yii::$app->request->post('weight');
         $model->hobby = Yii::$app->request->post('hobby');
         $model->annual_salary = Yii::$app->request->post('annual_salary');
         $model->car_type = Yii::$app->request->post('car_type');
         $model->often_go = Yii::$app->request->post('often_go');
         $model->marry = Yii::$app->request->post('marry');
         $model->job = Yii::$app->request->post('job');
         $model->extra = Yii::$app->request->post('extra');
        */
        if($model->update()){
            WeeklyContent::updateAll(['name'=>$model->title],['album_id'=>$id]);
            $bgadminModel = new BgadminGirlMember();
            if(($bgModel = $bgadminModel::findOne(['flag'=>$model->flag]))!=null){
                $bgModel->weicaht = $postData['weichat'];
                $bgModel->cellphone = $postData['cellphone'];
                $bgModel->address_a = $postData['title'];
                $bgadminModel->address_b = $model->title2.'/'.$model->title3;
                $bgModel->age = $postData['age'];
                $bgModel->height = $postData['height'];
                $bgModel->weight = $postData['weight'];
                $bgModel->hobby = $postData['hobby'];
                $bgModel->like_type = $postData['like_type'];
                $bgModel->foreign = $postData['foreign'];
                $bgModel->job = $postData['job'];
                $bgModel->cup = $postData['cup'];
                $bgModel->flag = $model->flag;
                $bgModel->sex = 1;
                $bgModel->vip = 1;
                $bgModel->coin = $model->worth;
                if(!$bgModel->update()){
                    $model->enable_comment = 1;
                    $model->update();
                }

            }else{
                $bgadminModel->weicaht = $postData['weichat'];
                $bgadminModel->cellphone = $postData['cellphone'];
                $bgadminModel->address_a = $postData['title'];
                $bgadminModel->address_b = $model->title2.'/'.$model->title3;
                $bgadminModel->age = $postData['age'];
                $bgadminModel->height = $postData['height'];
                $bgadminModel->weight = $postData['weight'];
                $bgadminModel->hobby = $postData['hobby'];
                $bgadminModel->like_type = $postData['like_type'];
                $bgadminModel->foreign = $postData['foreign'];
                $bgadminModel->job = $postData['job'];
                $bgadminModel->cup = $postData['cup'];
                $bgadminModel->flag = $model->flag;
                $bgadminModel->sex = 1;
                $bgadminModel->vip = 1;
                $bgadminModel->coin = $model->worth;
                if(!$bgadminModel->save()){
                    $model->enable_comment = 1;
                    $model->update();
                }
            }

            return $this->render('success');
        }
        return $this->render('index');
    }


    public function actionSuccess(){

        return $this->render('success');
    }

    public function actionUploader(){

        $id = Yii::$app->request->post('id');
        $collecting_text = $this->findModel($id);

        if($collecting_text->cover_id==-1||$collecting_text->cover_id==0){
            throw new ForbiddenHttpException('无效链接');
        }
        $data = $collecting_text->uploadf();

        $html = <<<defo
        <img onclick="delete_img($data[id])" src=$data[path] class="preview collecting-files-img">
defo;
        echo $html;
    }

    public function actionUploaderWeima(){

        $id = Yii::$app->request->post('id');
        $collecting_text = $this->findModel($id);

        if($collecting_text->cover_id==-1||$collecting_text->cover_id==0){
            throw new ForbiddenHttpException('无效链接');
        }
        $data = $collecting_text->uploadw();

        $html = <<<defo
        <img onclick="delete_img($data[id])" src=$data[path] class="preview">
defo;
        echo $html;
    }

    public function actionDelete($id){

        $model = $this->findModelImg($id);
        $model->delete();
        $qn = new QiniuUploader('files',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
        $qn->delete('shisangirl',$model->path);
        echo $id;
    }

    public function actionDeleteWeima($id){

        $model = $this->findModelImg($id);
        $model->delete();
        echo $id;
    }


    public function actionPass($id){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }
        $model = $this->findModel($id);
        $model->status = 2;
        if($model->update()){
            return $this->redirect(['info']);
        }else{
            return var_dump($model->errors);
        }
    }

    public function actionNoPass($id){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }
        $model = $this->findModel($id);
        $model->status = 0;
        if($model->update()){
            return $this->redirect(['info']);
        }else{
            return var_dump($model->errors);
        }
    }

    public function actionInfoDetail($id){

        if(Yii::$app->user->id!=13921){
            throw new ForbiddenHttpException('非法访问');
        }
        $model = $this->findModel($id);
        $img = $model->imgs;
        return $this->render('info-detail',['model'=>$model,'img'=>$img]);
    }

    protected function findModel($id)
    {
        if (($model = Weekly::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelImg($id)
    {
        if (($model = WeeklyContent::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}