<?php
namespace api\modules\v11\controllers;

use yii;
use yii\helpers\Response;
use yii\rest\ActiveController;
use api\components\CsvDataProvider;
use yii\filters\RateLimiter;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;

class FormThreadPushMsgController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\FormThreadPushMsg';
    public $serializer = [
        'class' => 'app\components\Serializer',
        'collectionEnvelope' => 'data',
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
     * @return CsvDataProvider
     * v11/form-thread-push-msgs?access_token={cid}?user_id={user_id}
     * 获取所有和他有关的帖子id，
     */

    public function actionIndex() {

    	$model = $this->modelClass;
        $user_id = Yii::$app->request->get('user_id');
        $query = $model::find()->where(['user_id'=>$user_id]);

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
     * @param $id
     * v11/form-thread-push-msgs/{user_id}?access_token={cid}
     * 获取所有和他有关的未读消息数量integer类型，
     */

    public function actionView($id) {
        $_model = $this->modelClass;
        $count = $_model::find()->where(['user_id'=>$id,'read_user'=>0])->count();
        yii\myhelper\Response::show('200',(integer)$count,(integer)$count);
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

