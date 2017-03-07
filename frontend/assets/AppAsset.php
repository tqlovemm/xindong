<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/site.css',
        'css/lrtk.css',
        'css/jquery-labelauty.css',
    ];
    public $js = [
        'js/masonry.pkgd.min.js',
        'js/lrtk.js',
        'js/jquery-labelauty.js',
        'js/jquery.more.js',
        'js/fm.selectator.jquery.js',
        'js/note/jaliswall.js',
        'js/address/distpicker.data.js',
        'js/address/distpicker.js',
        'js/jquery.lazyload.min.js',

    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
