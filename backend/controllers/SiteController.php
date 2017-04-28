<?php
namespace backend\controllers;

use app\components\SendTemplateSMS;
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

    public function actionSaveSession(){

        $session = \Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        $code = mt_rand(1000,9999);

        $mobile = \Yii::$app->request->post('mobile');

        $session->set('code',$code);

        $session->set('mobile',$mobile);

        $send = SendTemplateSMS::send($mobile,array($code,'10'),"155776");

        echo json_encode($send);

    }

    public function actionJudgeTrue(){

        $session = \Yii::$app->session;
        if(!$session->isActive)
            $session->open();

        $send_code = \Yii::$app->request->post('code');
        $send_mobile = \Yii::$app->request->post('mobile');

        $save_code = $session->get('code');
        $save_mobile = $session->get('mobile');

        $result = json_encode(array('statusCode'=>1045,'statusMsg'=>'验证码或手机号错误'));

        if(($send_code==$save_code) && ($send_mobile==$save_mobile)){
            $result = json_encode(array('statusCode'=>"000000",'statusMsg'=>'true'));
        }
        echo $result;
    }

}
