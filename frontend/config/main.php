<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$db = require(__DIR__ . '/../../common/config/db.php');

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
   /* 'defaultRoute' => 'user/dashboard',*/
    'defaultRoute'=>'site/index',
    'modules' => [
        'member' => [

            'class' => 'frontend\modules\member\Member',
            'aliases' => [
                '@themes' => 'root/themes/basic/layouts/'
            ],

        ],
        'sm' => [
            'class' => 'frontend\modules\sm\Sm',
        ],
        'bgadmin' => [

            'class' => 'frontend\modules\bgadmin\BgAdmin',
        ],
        'local' => [
            'class' => 'frontend\modules\local\Local',
        ],
        'weixin' => [

            'class' => 'frontend\modules\weixin\Weixin',

        ],
        'forum' => [
            'class' => 'frontend\modules\forum\Forum',
            'aliases' => [
                '@forum_icon' => '@web/uploads/forum/icon/', //图标上传路径
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/blog/photo/'
            ],
        ],
        'show' => [

            'class' => 'app\modules\show\Show',
            'aliases' => [

                '@avatar' => '@web/uploads/user/avatar/',

            ],
        ],

        'user' => [
            'class' => 'app\modules\user\UserModule',
            'aliases' => [
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/home/photo/'
            ]
        ],
        'home' => [
            'class' => 'app\modules\home\HomeModule',
            'aliases' => [
                '@avatar' => '@web/uploads/user/avatar/',
                '@photo' => '@web/uploads/home/photo/'
            ]
        ],
        'test' => [
            'class' => 'frontend\modules\test\Test',

        ],
        'voted' => [
            'class' => 'app\modules\voted\voted',
        ],
        'abdomen' => [
            'class' => 'frontend\modules\abdomen\Abdomen',
        ],
    ],
    'components' => [
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false, // 在URL路径中是否显示脚本入口文件

            'rules' => [
                'u/<id:[\x{4e00}-\x{9fa5}a-zA-Z0-9_]*>' => 'user/view',
                'about'=>'site/about',
                'contact'=>'site/contact',
                'contact2'=>'site/contact2',
                'services'=>'site/services',
                'date-today'=>'site/date-today',
                'date-quality'=>'site/high-quality-gender',
                'date-view/<id:\d+>'=>'site/date-view',
                'files/<id>'=>'collecting-files/index',
                '17-files'=>'collecting-seventeen-files/index',
                '17-files/success/<id>'=>'collecting-seventeen-files/success',
                '17-files/message/<id>'=>'collecting-seventeen-files/message',
                '17-files/private/<id>'=>'collecting-seventeen-files/private-information',
                'join/<id>'=>'member/auto-join/check',
                'date-past'=>'site/date-past',
                'dating'=>'site/dating',
                'hear-view'=>'site/exciting',
                'beautiful-people'=>'site/beautiful-people',
                'support-team'=>'site/support-team',
                'hear-view/<id:\d+>'=>'site/hear-view',
                'redirect'=>'site/redirect',
                'red'=>'site/red',
                'datingt'=>'site/datingt',
                'join/<id:\d+>'=>'member/auto-join/check',
                'login'=>'site/login',
                'signup'=>'site/signup',
                'logout'=>'site/logout',
                'setting/profile'=>'user/setting/profile',
                'setting/account'=>'/user/setting/account',
                'setting/security'=>'user/setting/security',
                'setting/mark'=>'user/setting/mark',
                'p/<id:\d+>' => 'user/view/view-post',
                'heart'=>'show/show-news',
                'heart-slide/<id:\d+>'=>'show/show-news/slide-content',
                'heart/<id:\d+>'=>'show/show-news/week-content',
                'firefighters'=>'/weixin/firefighters/firefighters-index',

            ],
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'userData' => [
            'class' => 'app\modules\user\models\UserData',
        ],
        'userProfile'=>[
            'class'=>'app\modules\user\models\Profile'
        ],
        'sigin' => [
            'class' => 'app\modules\home\models\Sigin',
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/basic',
                    '@app/modules' => '@app/themes/basic/modules',
                ],
            ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
    ],
    'params' => $params,


];

