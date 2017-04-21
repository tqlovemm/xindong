<?php
namespace backend\controllers;

use backend\components\MyBehavior;

use backend\models\AdminLoginRecord;
use Yii;
use yii\db\Query;
use yii\filters\AccessControl;
use common\components\BaseController;
use common\models\LoginForm;
use common\models\User;
use frontend\models\Counter;
use yii\myhelper\SystemMsg;
use yii\web\ForbiddenHttpException;

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

    public function actionInfoComputer(){


        echo $_SERVER['SERVER_ADDR'];
        // 通过执行操作符，等同于在命令行下执行该命令，要获取ip的根据返回内容截取
        $output = `ipconfig`;
        echo '<pre>'.$output.'</pre>';
        // 通过system函数，功能与执行操作符一样
        echo '<pre>';
        $last_line = system('ipconfig', $retval);
        echo '
	</pre>
	<hr />Last line of the output: ' . $last_line . '
	<hr />Return value: ' . $retval;

        return;



        $bIp = gethostbyname($_ENV['COMPUTERNAME']); //获取本机的局域网IP
        echo "本机IP：",$bIp,"\n";
        echo "本机主机名：",gethostbyaddr($bIp),"\n\n\n"; //gethostbyaddr 函数可以根据局域网IP获取主机名
//默认网关IP
        list($ipd1,$ipd2,$ipd3) = explode('.',$bIp);
        $mask = $ipd1 . "." . $ipd2 . "." . $ipd3 ;
        exec('arp -a',$aIp); //获取局域网中的其他IP
        foreach( $aIp as $ipv) {
            if(strpos($ipv,'接口') !== false) {//一下显示的IP是否是当前局域网中的 而不是其他的类型 可以在cmd下试一下命令
                $bool = false;
                preg_match('/(?:(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))\.){3}(?:25[0-5]|2[0-4]\d|((1\d{2})|([1-9]?\d)))/',$ipv,$arr);
                if(strcmp($arr[0],$bIp) == 0) {
                    $bool = true;
                }
            } else {
                if($bool) {
                    $str = preg_replace('/\s+/', '|', $ipv);
                    $sArr = explode('|',$str);
                    if($sArr[1] == 'Internet' || empty($sArr[1])) {
                        continue;
                    }
                    //去除默认网关
                    if(strcmp($mask . ".1", $sArr[1]) == 0) {
                        continue;
                    }
                    //去除同网关下255的IP
                    if(strcmp($mask . ".255", $sArr[1]) == 0) {
                        continue;
                    }
                    //去除组播IP
                    list($cIp) = explode('.', $sArr[1]);
                    if($cIp >= 224 && $cIp <= 239) {
                        continue;
                    }
                    echo "IP地址：|",$sArr[1],"|\n";
                    echo "MAC地址：",$sArr[2],"\n";
                    echo "主机名：",gethostbyaddr($sArr[1]),"\n";
                    echo "\n\n";
                }
            }
        }

    }

    public function actionIndex()
    {
        $userCount = Yii::$app->db->createCommand("SELECT count(*) as num FROM {{%user}}")->queryScalar();

/*        $host_name = exec("hostname");
        $host_ip = gethostbyname($host_name);
        $ip = isset($_SERVER["HTTP_X_REAL_IP"])?$_SERVER["HTTP_X_REAL_IP"]:$_SERVER["REMOTE_ADDR"];
        $adminModel = new AdminLoginRecord();
        if(empty($adminModel::findOne(['web_id'=>$ip,'hostname'=>$host_ip]))){
            $adminModel->web_id = $ip;
            $adminModel->hostname = $host_ip;
            $adminModel->save();
        }*/

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
