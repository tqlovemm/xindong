<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2015/12/11
 * Time: 9:46
 */

namespace yii\myhelper;
use frontend\models\Counter;

class TotalCounter
{

    public static function counter(){

        $counter = new Counter();
        if(!isset($_SESSION['counter']))
        {
            $_SESSION['counter'] = true;
            $counter->create();
        }

    }
}