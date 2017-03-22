<?php


namespace backend\modules\exciting\controllers;

use backend\components\AddRecord;
use Yii;
use backend\modules\exciting\models\Exciting;
use yii\data\SqlDataProvider;
use common\components\BaseController;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/*
    $old = json_encode($model->oldAttributes);
    $new = json_encode($model->attributes);

    $data_arr = array('description'=>"修改系统消息{$id}的信息",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
    AddRecord::record($data_arr);
**/

class ExcitingController extends BaseController
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
                        'actions' => ['create', 'update', 'view', 'upload', 'index','delete'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $count = Yii::$app->db
            ->createCommand("SELECT count(*) FROM {{%weekly}}  WHERE status=1")
            ->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => 'SELECT id, cover_id, status,title,content,url FROM {{%weekly}} WHERE status=1 order by id desc',
            'totalCount' => $count,
            'pagination' => array('pageSize' => 20),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);


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
     * @return string
     * hhfas
     */
    public function actionUpload($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isPost) {
            $upload = $model->upload();
            if($upload){
                $data_arr = array('description'=>"为心动故事{$id}上传图片",'data'=>json_encode($upload),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);
            }
        }
        return $this->render('upload', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Exciting();
        $path = 'http://admin.13loveme.com/images/hear'.'/'.rand(1,20).'.jpg';
        if ($model->load(Yii::$app->request->post())) {
            $model->url = $path;
            if($model->save()){

                $data_arr = array('description'=>"创建心动故事{$model->id}的信息",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>1);
                AddRecord::record($data_arr);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }else{
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
            if($model->update()){
                $data_arr = array('description'=>"修改心动故事{$id}的信息",'data'=>'','old_data'=>$old,'new_data'=>$new,'type'=>3);
                AddRecord::record($data_arr);
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
            $data_arr = array('description'=>"删除心动故事{$id}的信息",'data'=>json_encode($model->attributes),'old_data'=>'','new_data'=>'','type'=>2);
            AddRecord::record($data_arr);
        }

        return $this->redirect('index');
    }

    protected function findModel($id)
    {
        if (($model = Exciting::findOne($id)) !== null) {

            return $model;

        } else {

            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
