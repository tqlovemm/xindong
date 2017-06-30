<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;
use yii\web\View;
/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class WeiUserAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'weui02/dist/style/weui.min.css',
        'weui02/dist/style/main.css',
    ];

   public $depends = [
      /*  'yii\web\YiiAsset',*/
/*        'yii\bootstrap\BootstrapPluginAsset',*/
    ];

    public $js = [
/*       'weui02/dist/js/jweixin-1.0.0.js',
        'weui02/dist/js/vendor.js',*/
 /*       'weui02/dist/js/app.js',*/
    /* 'js/jquery-1.11.3.js',*/
     'weui02/dist/example/zepto.min.js',
    ];

    public $jsOptions = ['position' => View::POS_HEAD];
}
