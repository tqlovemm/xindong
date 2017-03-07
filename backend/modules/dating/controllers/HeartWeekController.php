<?php


namespace backend\modules\dating\controllers;

use Yii;

use yii\imagine\Image;
use backend\modules\dating\models\HeartWeek;
use backend\modules\dating\models\HeartWeekSearch;
use yii\web\HttpException;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\myhelper\Random;
use yii\helpers\Json;
use yii\web\UploadedFile;
class HeartWeekController extends BaseController
{

    public $enableCsrfValidation = false;


    public function actionIndex()
    {

        $searchModel = new HeartWeekSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
     /*   $count = Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%weekly}}  WHERE status=2")
            ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT id, cover_id, status,title,content,url,avatar FROM {{%weekly}} WHERE created_by = :user_id and status=2 ORDER BY updated_at DESC',
            'params' => [':user_id' => Yii::$app->user->id],
            'totalCount' => $count,
            'pagination' => array('pageSize' => 20),
        ]);*/

        return $this->render('index', [
//            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }
    public function actionHeartWeekHide($id){

        $model = $this->findModel($id);

        if($model->cover_id==-1){

            Yii::$app->db->createCommand("update {{%heartweek}} set cover_id=0 where id=$id")->execute();
            echo "隐";

        }else{

            Yii::$app->db->createCommand("update {{%heartweek}} set cover_id=-1 where id=$id")->execute();
            echo "显";

        }


    }

    public function actionDateAvatar($id)
    {
        $model = $this->findModel($id);

        //上传头像
        Yii::setAlias('@upload', '@backend/web/uploads/heartweek/avatar/');

        if (Yii::$app->request->isPost && !empty($_FILES)) {

            $extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if($extension=='jpeg'||$extension=='JPEG'){
                $extension='jpg';
            }
            $fileName = $model->id.'_'.time().rand(1,10000).'.'.$extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 450, 450)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);

            //删除旧头像
            if (file_exists(Yii::getAlias('@upload').$model->avatar))

                @unlink(Yii::getAlias('@upload').$model->avatar);

            $model->avatar = Yii::$app->request->getHostInfo().'/uploads/heartweek/avatar/'.$fileName;
            $model->update();
        }


        return $this->render('date-avatar', [

            'model' => $model,
        ]);
    }


    /*联动查询*/
    public function actionTypeList()
    {
        $type = \Yii::$app->request->get('type');

        return Json::encode(HeartWeek::getUrl($type));
    }

    public function actionAvatar($name = null,$id)
    {


        if (Yii::$app->request->isAjax) {

            if (($name = intval($name))) {

                if ($name >= 1 && $name <= 40) {

                    return Yii::$app->db->createCommand()->update('{{%heartweek}}', [
                        'avatar' => Yii::$app->request->getHostInfo().'/uploads/dating/avatar/default/' . $name . '.jpg',
                    ], 'id=:id', [':id' => $id])->execute();
                } else {
                    throw new HttpException(404,'The requested page does not exist.');
                }
            } else {

                return $this->renderAjax('avatar');
            }
        } else {
            throw new ForbiddenHttpException('You are not allowed to perform this action.');
        }
    }


    public function actionView($id)
    {
        $model = $this->findModel($id);
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * 上传图片到相册
     * @param integer $id 相册ID
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


    public function actionCreate()
    {
        $model = new HeartWeek();

        if ($model->load(Yii::$app->request->post())) {

            if(empty($model->number)){

                $model->number = Random::get_random_code(6,5).time();
            }

            /**
             * 声色需要上传MP3
            */
            if($model->status==0){

                $model->file = UploadedFile::getInstance($model, 'file');

                $model->file = $model->uploads();
            }


            if($model->save()){

                return $this->redirect('index');

            }else{

                return var_dump($model->getErrors());

            }



        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);


        if ($model->load(Yii::$app->request->post()) ) {

            if($model->status==0){

                $model->file = UploadedFile::getInstance($model, 'file');
                $model->file = $model->uploads();
            }


            if($model->save()){

                return $this->redirect(['view', 'id' => $model->id]);
            }

        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = HeartWeek::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
