<?php
namespace api\modules\v11\controllers;

use api\components\CsvDataProvider;
use api\modules\v11\models\FormThread;
use api\modules\v11\models\FormThreadComments;
use api\modules\v11\models\User;
use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;

class FormThreadCommentsController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadComments';
    public $serializer = [
        'class' => 'yii\rest\Serializer',
        'collectionEnvelope' => 'items',
    ];
    public function behaviors() {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => CompositeAuth::className(),
            'authMethods' => [
                QueryParamAuth::className(),
            ],
        ];
        $behaviors['rateLimiter'] = [
            'class' => RateLimiter::className(),
            'enableRateLimitHeaders' => true,
        ];
        return $behaviors;
    }

    public function actions() {
        $action = parent::actions();
        unset($action['index'], $action['view'], $action['create'], $action['update'], $action['delete']);
        return $action;
    }

    /**
     * @return mixed
     * 发帖评价接口post
     * /v11/form-thread-comments?access-token={cid}
     *
     * post 提交，必填字段：'thread_id'帖子id, 'comment'评价内容,'first_id'评价人的user_id；如果又针对该评价的回复请务必添加second_id 回复人user_id，
     *
     * {
    "code": "203",
    "message": "评价失败",
    "data": "评价人不存在"
    }
     */
    public function actionCreate() {

    	$model = new $this->modelClass();
    	$model->load(Yii::$app->request->getBodyParams(), '');
        if(empty(FormThread::findOne($model->thread_id))){
            yii\myhelper\Response::show('203','评价失败',"该帖子不存在");
        }elseif(empty(User::findOne($model->first_id))){
            yii\myhelper\Response::show('203','评价失败',"评价人不存在");
        }else{
            if (!$model->save()) {
                yii\myhelper\Response::show('203','评价失败', array_values($model->getFirstErrors())[0]);
            }else{
                $thread = FormThread::findOne($model->thread_id);
                $thread->thumbs_count+=1;
                $thread->base64Images = "add";
                if($thread->update()){
                    return $model;
                }else{
                    return $thread->errors;
                }
            }
        }

    }

    /**
     * @param $id
     *
     * 删除评价接口delete
     * 必传?user_id={user_id}，使用者user_id,为了防止删除非自己评论
     * /v11/form-thread-comments/{comment_id}?user_id={user_id}&access-token={cid}
     *
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $get = Yii::$app->request->getBodyParams();
        if($get['user_id']==$model->first_id){
            if($model->delete()){
                yii\myhelper\Response::show('200','删除成功');
            }
        }
    }


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

