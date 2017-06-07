<?php
namespace backend\controllers;

use app\components\SendTemplateSMS;
use mdm\admin\models\AdminChangePassword;
use Yii;
use yii\filters\AccessControl;
use common\components\BaseController;
use backend\models\LoginForm;
use yii\myhelper\Easemob;

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
                        'actions' => ['logout', 'index', 'cache','test'],
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

    public function actionTest(){

        $msg = '你终于来了~我等你很久了💕

想要约个好看的ta，快来玩转我们吧，我们有应接不暇的小活动，如小黑屋，周末勾搭群等等尺度大到你想不到️㊙️

快把你想了解的话题告诉我们的知心客服小姐姐吧，app客服没有及时回复的话，你也可以在微信添加shisan-32进行咨询哦🎈';

        $ids[] = "xdd";
        $data['target_type']= 'users';
        $data['target'] = $ids;
        $data['msg'] = ['type'=>'txt','msg'=>$msg];
        $data['from'] = 'shisan-kefu';//shisan-kefu
        $this->setMes()->sendText($data);
    }

    //环信信息
    protected function setMes(){

        $options = array(
            'client_id'  => Yii::$app->params['client_id'],   //你的信息
            'client_secret' => Yii::$app->params['client_secret'],//你的信息
            'org_name' => Yii::$app->params['org_name'],//你的信息
            'app_name' => Yii::$app->params['app_name'] ,//你的信息
        );
        $e = new Easemob($options);
        return $e;
    }

    public function actionIndex()
    {

        $adminChangePassword = new AdminChangePassword();
        $res = $adminChangePassword::find()->select('max(created_at) as expire')->where(['created_by'=>Yii::$app->user->id])->asArray()->one();
        return $this->render('index',[
            'res'=>$res,
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
