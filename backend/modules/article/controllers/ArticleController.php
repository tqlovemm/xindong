<?php

namespace backend\modules\article\controllers;

use Yii;
use backend\modules\article\models\Article;
use backend\modules\article\models\ArticleSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\Qiniu\QiniuUploader;
use yii\db\Query;


/**
 * ArticleController implements the CRUD actions for article model.
 */
class ArticleController extends Controller
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
    public function actions()
    {
        $url = Yii::$app->request->hostInfo;
        return [
            'ueditor' => [
                'class' => 'common\widgets\ueditor\UeditorAction',
                'config'=>[
                    //上传图片配置
                    'imageUrlPrefix' => $url, /* 图片访问路径前缀 */
                    'imagePathFormat' => "/uploads/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                    'videoUrlPrefix' => $url,
                    'videoPathFormat' => "/uploads/{yyyy}{mm}{dd}/{time}{rand:6}",
                ]
            ]
        ];
    }
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionCreate()
    {
        $model = new Article();

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['wimg']['name']){
                $qn = new QiniuUploader('wimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid();
                $qiniu = $qn->upload_water('appimages',"uploads/qinhua/$mkdir");
                $wimg =  Yii::$app->params['appimages'].$qiniu['key'];
                $model->wimg = $wimg;
            }
            if($model->save()){
                return $this->redirect(['index']);
            }else{
                return "添加失败";
            }
        } else {
            $typeres = (new Query())->select('tid,typename')->from('{{%article_type}}')->all();
            for($i=0;$i<count($typeres);$i++){
                $typearr[$typeres[$i]['tid']] = $typeres[$i]['typename'];
            }
            $labelres = (new Query())->select('lid,labelname')->from('{{%article_label}}')->all();
            $labelarr[0] = "无";
            for($k=0;$k<count($labelres);$k++){
                $labelarr[$labelres[$k]['lid']] = $labelres[$k]['labelname'];
            }
            return $this->render('create', [
                'model' => $model,
                'type' => $typearr,
                'label' => $labelarr,
            ]);
        }
    }


    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            if($_FILES['wimg']['name']){
                $qn = new QiniuUploader('wimg',Yii::$app->params['qnak1'],Yii::$app->params['qnsk1']);
                $mkdir = date('Y').'/'.date('m').'/'.date('d').'/'.uniqid().substr($_FILES['wimg']['name'], strrpos($_FILES['wimg']['name'], '.'));
                $qiniu = $qn->upload_water('appimages',"uploads/qinhua/$mkdir");
                $wimg =  Yii::$app->params['appimages'].$qiniu['key'];
                $model->wimg = $wimg;
            }
            if($model->save()){
                return $this->redirect(['index']);
            }else{
                return "添加失败";
            }
        } else {
            $typeres = (new Query())->select('tid,typename')->from('{{%article_type}}')->all();
            for($i=0;$i<count($typeres);$i++){
                $typearr[$typeres[$i]['tid']] = $typeres[$i]['typename'];
            }
            $labelres = (new Query())->select('lid,labelname')->from('{{%article_label}}')->all();
            $labelarr[0] = "无";
            for($k=0;$k<count($labelres);$k++){
                $labelarr[$labelres[$k]['lid']] = $labelres[$k]['labelname'];
            }
            return $this->render('update', [
                'model' => $model,
                'type' => $typearr,
                'label' => $labelarr,
            ]);
        }
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionShow($id){
        $this->layout = false;
        $model = article::findOne($id);
        $user =  (new Query())->select('nickname,username')->from('{{%user}}')->where(['id'=>$model->created_id])->one();
        if($user['nickname']){
            $name = $user['nickname'];
        }else{
            $name = $user['username'];
        }
        return $this->render('show', [
            'model' => $model,
            'username' => $name,
        ]);
    }

    protected function findModel($id)
    {
        if (($model = article::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
