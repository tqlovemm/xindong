<?php
namespace backend\controllers;

use backend\components\MyBehavior;
use frontend\models\UserAvatarCheck;

use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use common\components\BaseController;
use common\models\LoginForm;
use common\models\User;
use frontend\models\Counter;
use yii\myhelper\SystemMsg;

/**
 * Site controller
 */

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
                        'actions' => ['logout', 'index', 'phpinfo', 'cache',
                            'pcheck','pass','npass','feedback',
                            'feeddelete','feedview','claims',
                            'claimsview','claimsdelete','visit','cvisit','pclaims',
                            'pclaims-delete','send-mailer','file-check','file-check-op'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                 /*       'matchCallback' => function ($rule, $action) {
                            $ip = Yii::$app->getRequest()->getUserIP();
                            if(MyBehavior::enter($ip)){
                                return true;
                            }
                        }*/
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
 /*       $postCount = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%forum_post}}")->queryScalar();
        $forumCount = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%forum_thread}}")->queryScalar();*/
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
