<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use common\components\BaseController;
use common\models\LoginForm;

class SiteController extends BaseController
{
    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['error','login'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'cache'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }


    public function actionIndex()
    {
        $userCount = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%user}}")->queryScalar();

        return $this->render('index',[
            'userCount' => $userCount,
            'postCount' => 0,
            'forumCount' => 0,
        ]);
    }

    public function actionLogin()
    {
        $this->layout = 'site';

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionCache($action = null)
    {
        switch ($action) {
            case 'clearall':
                Yii::$app->cache->flush();
                break;
            
            default:
                
                break;
        }
        return $this->render('cache');
    }

}
