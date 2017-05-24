<?php

namespace frontend\modules\article\controllers;

use Yii;
use frontend\modules\article\models\ArticleComment;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\db\Query;
use yii\data\Pagination;


/**
 * ArticleController implements the CRUD actions for article model.
 */
class ArticleController extends Controller
{
    public $enableCsrfValidation = false;
    public $cmodelClass = 'backend\modules\article\models\Article';
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
    public function actionShow(){
        $id = Yii::$app->request->get('id');
        $model = new ArticleComment();
        if($model->load(Yii::$app->request->post(),'')){
            $this->layout = false;
            $cmodel = new $this->cmodelClass();
            $content = $cmodel::findOne($id);
            $where = " status =1 and id <> ".$content->created_id;
            $articlearr = $cmodel::find()->where($where)->orderBy('created_at desc')->limit(2)->all();
            $user =  (new Query())->select('nickname,username')->from('{{%user}}')->where(['id'=>$content->created_id])->one();
            if($user['nickname']){
                $name = $user['nickname'];
            }else{
                $name = $user['username'];
            }
            $model->created_id = $content->created_id;
            $model->aid = Yii::$app->request->post('aid');
            $model->content = Yii::$app->request->post('content');
            if($model->save()){
                $cyes = 1;
            }else{
                $cyes = 2;
            }
            return $this->redirect("show?id=$id", [
                'cmodel' => $content,
                'username' => $name,
                'articlearr' => $articlearr,
                'cyes' => $cyes,
            ]);
        }else{
            $this->layout = false;
            $cmodel = new $this->cmodelClass();
            $content = $cmodel::findOne($id);
            $where = " status =1 and id <> ".$content->created_id;
            $articlearr = $cmodel::find()->where($where)->orderBy('created_at desc')->limit(2)->all();
            $user =  (new Query())->select('nickname,username')->from('{{%user}}')->where(['id'=>$content->created_id])->one();
            if($user['nickname']){
                $name = $user['nickname'];
            }else{
                $name = $user['username'];
            }
            return $this->render('show', [
                'cmodel' => $content,
                'username' => $name,
                'articlearr' => $articlearr,
            ]);
        }
    }
    public function actionGetcomment(){
        $aid = intval($_GET['aid']);
        if(empty($aid)){
            return '';
        }
        $model = new ArticleComment();
        $pages = new Pagination(['totalCount' =>$model::find()->count(), 'pageSize' => '3']);
        $pages->validatePage=false;
        $res = (new Query())->select('c.id,c.content,c.created_at,u.username,u.nickname,u.avatar')->from('{{%article_comment}} AS c')->leftJoin('{{%user}} AS u','u.id = c.created_id')->offset($pages->offset)->limit($pages->limit)->orderby('created_at desc')->where("aid = $aid")->all();
        $time = time();
        for($i=0;$i<count($res);$i++){
            if(!$res[$i]['nickname']){
                $res[$i]['nickname'] = $res[$i]['username'];
            }
            $res[$i]['time'] = $time-$res[$i]['created_at'];
            if($res[$i]['time'] >= 3600){
                $res[$i]['time'] = floor($res[$i]['time']/3600)."小时前";
            }else{
                $res[$i]['time'] = floor($res[$i]['time']/60)."分钟前";
            }
        }
        return json_encode($res);
    }
}
