<?php


namespace backend\modules\dating\controllers;

use backend\components\AddRecord;
use common\Qiniu\QiniuUploader;
use Yii;
use yii\imagine\Image;
use backend\modules\dating\models\Dating;
use backend\modules\dating\models\DatingSearch;
use yii\web\HttpException;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\myhelper\Random;
use yii\helpers\Json;
class DatingController extends BaseController
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['create', 'update', 'view','dating-hide', 'upload', 'index','delete','date-avatar','avatar','type-list'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }


    public function actionIndex()
    {

        $searchModel = new DatingSearch();
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
    public function actionDatingHide($id){

        $model = $this->findModel($id);

        if($model->cover_id==-1){

            $model->cover_id = 0;
            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            if($model->update()){
                $data_array = array('description'=>"显示出觅约妹子编号{$model->number}的资料",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_array);
            }

            echo "隐";

        }else{

            $model->cover_id = -1;
            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);

            if($model->update()){
                $data_array = array('description'=>"隐藏觅约妹子编号{$model->number}的资料",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_array);
		
           	 echo "显";
            }

        }
    }

    public function actionDateAvatar($id)
    {
        $model = $this->findModel($id);

        //上传头像
       // Yii::setAlias('@upload', '@backend/web/uploads/dating/avatar/');

        if (Yii::$app->request->isPost && !empty($_FILES)) {

            $qn = new QiniuUploader('file',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
            $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.$id;
            $qiniu = $qn->upload('shisangirl',"uploads/dating/avatar/$mkdir");
            /*$extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if($extension=='jpeg'||$extension=='JPEG'){
                $extension='jpg';
            }
            $fileName = $model->id.'_'.time().rand(1,10000).'.'.$extension;

            Image::thumbnail($_FILES['file']['tmp_name'], 450, 450)->save(Yii::getAlias('@upload') . $fileName, ['quality' => 80]);

            //删除旧头像
            if (file_exists(Yii::getAlias('@upload').$model->avatar))

                @unlink(Yii::getAlias('@upload').$model->avatar);*/

            $model->avatar = $qiniu['key'];
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

        return Json::encode(Dating::getUrl($type));
    }

    public function actionAvatar($name = null,$id)
    {


        if (Yii::$app->request->isAjax) {

            if (($name = intval($name))) {

                if ($name >= 1 && $name <= 200) {

                    return Yii::$app->db->createCommand()->update('{{%weekly}}', [
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
     * @param $id
     * @param string $type
     * @return string
     */
    public function actionUpload($id,$type='dating')
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $model->upload($type);
        }

        return $this->render('upload', [
            'model' => $this->findModel($id),

        ]);
    }


    public function actionCreate()
    {
        $model = new Dating();

        if ($model->load(Yii::$app->request->post())) {

            $model->title = trim($model->title);
            if(empty($model->number)){
                $model->number = Random::get_random_code(6,5).'X';
            }
            if($model->save()){

                $data_array = array('description'=>"创建妹子编号{$model->number}的最新觅约信息",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_array);
                return $this->redirect(['view', 'id' => $model->id]);
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

        if ($model->load(Yii::$app->request->post())) {

            $old = json_encode($model->oldAttributes);
            $new = json_encode($model->attributes);
	    $model->cover_id=0;
            if($model->update()){
                $data_array = array('description'=>"修改觅约信息妹子编号{$model->number}的资料",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_array);
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        if($model->delete()){
            $data_array = array('description'=>"删除妹子编号{$model->number}的觅约信息",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_array);
        }
        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Dating::findOne($id)) !== null) {

            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
