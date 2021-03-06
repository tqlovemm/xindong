<?php
namespace api\modules\v11\controllers;

use yii;
use api\components\CsvDataProvider;
use api\modules\v11\models\FormThread;
use api\modules\v11\models\User;
use yii\rest\ActiveController;
use yii\web\NotFoundHttpException;
use yii\myhelper\Response;
class FormThreadThumbsUpController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadThumbsUp';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }
    /**
     * @return CsvDataProvider
     * v11/form-thread-thumbs-ups?thread_id={thread_id}是帖子id
     * get 获取和该帖子有关的所有点赞
     */
    public function actionIndex() {

        $model = $this->modelClass;
        $thread_id= Yii::$app->request->get('thread_id');
        $query =  $model::find()->where(['thread_id'=>$thread_id]);

        return new CsvDataProvider([
            'query' =>  $query,
            'pagination' => [
                'pageSize' => 20,
            ],
            'sort' => [
                'defaultOrder' => [
                    'created_at' => SORT_DESC,
                ]
            ],
        ]);
    }

    /**
     * @return array
     * post
     * sing加密
     * v11/form-thread-thumbs-ups
     * 必传参数，user_id,thread_id
     *{
    "code": "203",
    "message": "点赞失败",
    "data": "已经点赞"
    }
     */
    public function actionCreate() {

    	$model = new $this->modelClass();
    	$model->load(Yii::$app->request->getBodyParams(), '');
        $decode = new yii\myhelper\Decode();
        if(!$decode->decodeDigit($model->user_id)){
            Response::show(210,'参数不正确');
        }
        if(empty(FormThread::findOne($model->thread_id))){
            Response::show('203','该帖子不存在',"该帖子不存在");
        }elseif(empty(User::findOne($model->user_id))){
            Response::show('203','评价人不存在',"评价人不存在");
        }else{
            if (!$model->save()) {
                Response::show('203',array_values($model->getFirstErrors())[0],array_values($model->getFirstErrors())[0]);
            }else{
                $thread = FormThread::findOne($model->thread_id);
                $thread->thumbs_count+=1;
                $thread->base64Images = "add";
                if($thread->update()){
                    return $thread;
                }else{
                    Response::show('203',array_values($thread->getFirstErrors())[0],array_values($thread->getFirstErrors())[0]);
                }
            }
        }
    }

   /**
     * @param $id
     * @return int
     * delete
     * v11/form-thread-thumbs-ups/{id}?access-token={cid}
     *
     */
/*    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $get = Yii::$app->request->getBodyParams();
        if($get['user_id']==$model->user_id){
            if($model->delete()){
                $thread = FormThread::findOne($model->thread_id);
                $thread->thumbs_count-=1;
                $thread->update();
                yii\myhelper\Response::show('200','删除成功');
            };
        }else{
            yii\myhelper\Response::show('201','删除失败','您无权删除别人的点赞');
        }
    }*/


    protected function findModel($id)
    {
        $modelClass = $this->modelClass;

        if (($model = $modelClass::findOne($id)) !== null) {
            return $model;
        } else {
            throw new yii\web\NotFoundHttpException('The requested page does not exist.');
        }
    }
}

