<?php
namespace api\modules\v11\controllers;

use api\modules\v11\models\FormThread;
use yii;
use yii\rest\ActiveController;
use yii\filters\RateLimiter;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;

class FormThreadThumbsUpController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadThumbsUp';
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

    public function actionCreate() {

    	$model = new $this->modelClass();
    	$model->load(Yii::$app->request->getBodyParams(), '');
        if (!$model->save()) {
            return array_values($model->getFirstErrors())[0];
        }else{
            $thread = FormThread::findOne($model->thread_id);
            $thread->thumbs_count+=1;
            if($thread->update()){
                return $model;
            }
            return $thread->errors;
        }
    }

    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $get = Yii::$app->request->getBodyParams();
        if($get['user_id']==$model->user_id){
            return $model->delete();
        }else{
            return 0;
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

