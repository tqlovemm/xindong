<?php

namespace app\modules\show\controllers;

use app\modules\show\models\HeartweekComment;
use Yii;
use app\modules\show\models\ShowNews;
use app\modules\show\models\NewsSearch;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\myhelper\FileUpload;

/**
 * ShowNewsController implements the CRUD actions for ShowNews model.
 */
class ShowNewsController extends Controller
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
     * Lists all ShowNews models.
     * @return mixed
     */

    public function actionIndex()
    {

        $this->layout = '/basic';
        $query = Yii::$app->db->createCommand('select id,name,thumb,path from {{%heartweek_content}} where album_id=4 order by created_at desc')->queryAll();
        $models = Yii::$app->db->createCommand('select id,title,content,url,avatar,created_at from {{%heartweek}} where status=2 order by created_at desc')->queryAll();
        $actives = Yii::$app->db->createCommand('select id,title,content,url,avatar,created_at from {{%heartweek}} where status=3 order by created_at desc')->queryAll();
        $voices = Yii::$app->db->createCommand('select id,title,content,url,avatar,created_at,file from {{%heartweek}} where status=0 order by created_at desc')->queryAll();

        return $this->render('index', [
            'query'=>$query,
            'models'=>$models,
            'voices'=>$voices,
            'actives'=>$actives,
        ]);
    }

    /**
     * Displays a single ShowNews model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }

    public function actionSlideContent($id){

        $this->layout = '/basic';
        $model = Yii::$app->db->createCommand("select * from {{%heartweek_slide_content}} where album_id=$id")->queryAll();
        $queries = Yii::$app->db->createCommand("select album_id,name from {{%heartweek_content}} where id=$id")->queryOne();
        $query = Yii::$app->db->createCommand("select * from {{%heartweek}} where id=$queries[album_id]")->queryOne();
        $comments = Yii::$app->db->createCommand("select * from {{%heartweek_comment}} where weekly_id=$id")->queryAll();
        Yii::$app->db->createCommand("update {{%heartweek}} set read_count=read_count+1 where id=$queries[album_id]")->execute();
        return $this->render('week-content',['model'=>$model,'queries'=>$queries,'query'=>$query,'comments'=>$comments]);


    }


    public function actionWeekContent($id){

        $this->layout = '/basic';

        $query = Yii::$app->db->createCommand("select * from {{%heartweek}} where id=$id")->queryOne();
        $model = Yii::$app->db->createCommand("select * from {{%heartweek_content}} where album_id=$id")->queryAll();
        $comments = Yii::$app->db->createCommand("select * from {{%heartweek_comment}} where weekly_id=$id")->queryAll();
        Yii::$app->db->createCommand("update {{%heartweek}} set read_count=read_count+1 where id=$id")->execute();
        return $this->render('week-content',['model'=>$model,'query'=>$query,'comments'=>$comments]);

    }

    public function actionAjaxWeekClick($id){

        if(!Yii::$app->session->isActive){
            Yii::$app->session->open();
            if(!Yii::$app->session->get('only_first')||Yii::$app->session->get('only_first')!==$id){
                Yii::$app->db->createCommand("update {{%heartweek}} set click_count=click_count+1 where id=$id")->execute();
                Yii::$app->session->set('only_first',$id);
            }
        }

        $query = (new Query())->select('click_count')->from('{{%heartweek}}')->where('id=:id',[':id'=>$id])->one();
        return $query['click_count'];


    }

    public function actionComment($id){

        $model = new HeartweekComment();

        $model->weekly_id = $id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            return $this->redirect(['week-content', 'id' => $id]);

        } else {

            return $this->render('comment', [
                'model' => $model,
            ]);
        }

    }
    public function actionNote($id){

        session_start();
        if(!isset($_SESSION['first_comment'])){$_SESSION['first_comment'] = time();}

        $first_comment = $_SESSION['first_comment'];

        $query = Yii::$app->db->createCommand("select likes from {{%heartweek_comment}} WHERE id=$id and first_comment=$first_comment")->queryOne();

        if(empty($query)){

            Yii::$app->db->createCommand("update {{%heartweek_comment}} set likes=likes+1,first_comment=$first_comment where id=$id")->execute();
        }

        $count = Yii::$app->db->createCommand("select likes from {{%heartweek_comment}} WHERE id=$id")->queryOne();


        echo $count['likes'];
    }



    /**
     * Creates a new ShowNews model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ShowNews();
        $up = new fileupload;
        //设置属性(上传的位置， 大小， 类型， 名是是否要随机生成)
        $up -> set("path", "./uploads/show");
        $up -> set("maxsize", 2000000);
        $up -> set("allowtype", array("gif", "png", "jpg","jpeg"));
        $up -> set("israndname", true);

        //使用对象中的upload方法， 就可以上传文件， 方法需要传一个上传表单的名子 pic, 如果成功返回true, 失败返回false

        if(!empty($_POST)){

            if($up -> upload("image")) {

                $images =  $up->getFileName();
                $extpath = "http://13loveme.com/uploads/show";
                $model->content = $_POST['content'];
                $model->path = $extpath.'/'.$images[0];
                if($model->save()){
                    return $this->redirect(['view', 'id' => $model->id]);
                }else{
                    echo 'cccccccccccccccc';
                }

            } else {
                echo '<pre>';
                //获取上传失败以后的错误提示
                var_dump($up->getErrorMsg());
                echo '</pre>';
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);

    }
    public function actionCreate2()
    {
        $model = new ShowNews();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }



    /**
     * Updates an existing ShowNews model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ShowNews model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ShowNews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ShowNews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ShowNews::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
