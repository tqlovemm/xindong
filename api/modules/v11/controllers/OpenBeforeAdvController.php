<?php
namespace api\modules\v11\controllers;

use api\modules\v11\models\OpenBeforeAdv;
use yii;
use yii\rest\ActiveController;
use api\components\CsvDataProvider;
use yii\filters\RateLimiter;
use yii\web\NotFoundHttpException;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;

class OpenBeforeAdvController extends ActiveController {

    public $modelClass = 'api\modules\v11\models\OpenBeforeAdv';
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
     * @return mixed
     * get
     * v11/open-before-advs?access-token={cid}
     *{
    "code": "200",
    "message": "success",
    "data": {
    "adv_id": 1,
    "content": "hhh",
    "openUrl": "http://www.13loveme.com",
    "contentSize": "1251*2540",
    "duration": 5,
    "status": 10
    }
    }
     *
     * {
    "code": "203",
    "message": "fail",
    "data": "当前没有可展示广告"
    }
     */
    public function actionIndex() {
    	$model = $this->modelClass;
        $query = $model::findOne(['status'=>10]);
        if(empty($query)){
            yii\myhelper\Response::show('203','fail','当前没有可展示广告');
        }
        yii\myhelper\Response::show('200','success',$query->getAttributes());
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

