<?php
namespace api\modules\v11\controllers;

use yii;
use yii\db\Query;
use yii\helpers\Response;
use yii\rest\ActiveController;
use yii\data\ActiveDataProvider;
use yii\filters\auth\CompositeAuth;
use yii\filters\auth\QueryParamAuth;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\RateLimiter;
class SavemeCommentController extends ActiveController {
    public $modelClass = 'api\modules\v11\models\SavemeComment';
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
        $actions = parent::actions();
        unset($actions['index'], $actions['view'], $actions['create'], $actions['update'], $actions['delete']);
        return $actions;
    }
    public function actionCreate() {
        $model = new $this->modelClass();
        $model->load(Yii::$app->request->getBodyParams(), '');
        $saveme_id = $model->saveme_id;
        $created_id = $model->created_id;
        $commentres = (new Query())->select('saveme_id,created_id,status')->from('{{%saveme_comment}}')->where(['saveme_id'=>$saveme_id,'created_id'=>$created_id])->orderBy('created_at desc')->one();
        if ($commentres) {
            Response::show('201','操作失败',"您已经对本次救火有过评论");
        }
        $model->status = 1;
        if(!$model->save()){
            // return $model->getFirstErrors();
            Response::show('201','操作失败',"评论失败");
        }
        Response::show('200','操作成功',"评论成功");
    }
}

