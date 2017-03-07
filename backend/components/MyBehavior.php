<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/11/14
 * Time: 11:32
 */

namespace backend\components;
use frontend\modules\member\models\EnterTheBackground;

class MyBehavior
{
    // 其它代码

    public static function enter($ip){

        $model = new EnterTheBackground();
        if(!empty($model::findOne(['allow_ip'=>$ip]))){
            return true;
        }
        return false;
    }
}