<?php
namespace app\components;
use Yii;
class PushConfig
{
    public static function config(){

        Yii::setAlias('@apppush','@backend/apppush');
        $path = Yii::getAlias('@apppush');
        require_once ($path.'/demo.php');
        //http的域名
        define('HOST','http://sdk.open.api.igexin.com/apiex.htm');

        //https的域名
        //define('HOST','https://api.getui.com/apiex.htm');

        define('APPKEY',Yii::$app->params['geAPPKEY']);
        define('APPID',Yii::$app->params['geAPPID']);
        define('MASTERSECRET',Yii::$app->params['geMASTERSECRET']);

        // define('DEVICETOKEN','');
        // define('Alias','请输入别名');
        //define('BEGINTIME','2015-03-06 13:18:00');
        //define('ENDTIME','2015-03-06 13:24:00');


    }
}