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
        $uid = Yii::$app->request->get('uid');
        if(!isset($uid)){
            return null;
        }
        $model = new ArticleComment();
        $url = Yii::$app->request->hostInfo;
        $this->layout = false;
        $cmodel = new $this->cmodelClass();
        $content = $cmodel::findOne($id);
        $where = " status =1 and id <> ".$content->id." and wtype = ".$content->wtype;
        $articlearr = $cmodel::find()->where($where)->orderBy('created_at desc')->limit(2)->all();
        $type = (new Query())->select('typename')->from('{{%article_type}}')->where(['tid'=>$content->wtype])->one();
        $user =  (new Query())->select('nickname,username')->from('{{%user}}')->where(['id'=>$content->created_id])->one();
        if($user['nickname']){
            $name = $user['nickname'];
        }else{
            $name = $user['username'];
        }
        $dianzan = (new Query())->select('id')->from('{{%article_like}}')->where(['aid'=>$id,'userid'=>$uid])->one();
        $shoucang = (new Query())->select('id')->from('{{%article_collection}}')->where(['aid'=>$id,'userid'=>$uid])->one();
        if($dianzan){
            $dzres = 1;
        }else{
            $dzres = 2;
        }
        if($shoucang){
            $scres = 1;
        }else{
            $scres = 2;
        }
        if($model->load(Yii::$app->request->post(),'') && Yii::$app->request->post('content')){
            $model->created_id = Yii::$app->request->post('uid');
            $model->aid = Yii::$app->request->post('aid');
            $model->content = Yii::$app->request->post('content');
            if($model->save()){
                $cyes = 1;
            }else{
                $cyes = 2;
            }
            return $this->redirect("show?id=$id&uid=$uid", [
                'cmodel' => $content,
                'username' => $name,
                'articlearr' => $articlearr,
                'cyes' => $cyes,
                'url' => $url,
                'dzres' => $dzres,
                'type' => $type,
                'scres' => $scres,
            ]);
        }else{
            return $this->render('show', [
                'cmodel' => $content,
                'username' => $name,
                'articlearr' => $articlearr,
                'url' => $url,
                'uid' => $uid,
                'dzres' => $dzres,
                'type' => $type,
                "scres" => $scres,
            ]);
        }
    }
    public function actionGetcomment(){
        $aid = intval($_GET['aid']);
        if(empty($aid)){
            return '';
        }
        $model = new ArticleComment();
        $pages = new Pagination(['totalCount' =>$model::find()->count(), 'pageSize' => '2']);
        $pages->validatePage=false;
        $res = (new Query())->select('c.id,c.content,c.created_at,u.username,u.nickname,u.avatar')->from('{{%article_comment}} AS c')->leftJoin('{{%user}} AS u','u.id = c.created_id')->offset($pages->offset)->limit($pages->limit)->orderby('created_at desc')->where("aid = $aid")->all();
        $time = time();
        for($i=0;$i<count($res);$i++){
            if(!$res[$i]['nickname']){
                $res[$i]['nickname'] = $res[$i]['username'];
            }
            $res[$i]['time'] = $time-$res[$i]['created_at'];
            if($res[$i]['time'] >= 24*3600){
                $res[$i]['time'] = date('Y-m-d',$res[$i]['created_at']);
            }else{
                if($res[$i]['time'] >= 3600){
                    $res[$i]['time'] = floor($res[$i]['time']/3600)."小时前";
                }elseif($res[$i]['time'] < 60){
                    $res[$i]['time'] = "刚刚";
                }else{
                    $res[$i]['time'] = floor($res[$i]['time']/60)."分钟前";
                }
            }
        }
        return json_encode($res);
    }
}
