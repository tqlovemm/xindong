<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$db = require(__DIR__ . '/../../common/config/db.php');

return [
    'id' => 'SSYT-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'bgadmin' => [
            'class' => 'backend\modules\bgadmin\BgAdmin',
        ],
        'sm' => [
            'class' => 'backend\modules\sm\Sm',
        ],
        'local' => [
            'class' => 'backend\modules\local\Local',
        ],
        'app' => [
            'class' => 'backend\modules\app\App',
        ],
        'seventeen' => [
            'class' => 'backend\modules\seventeen\Seventeen',
        ],
        'setting' => [
            'class' => 'backend\modules\setting\SettingModule',
        ],
        'collecting-file' => [
            'class' => 'backend\modules\collecting\Collecting',
        ],
        'financial' => [
            'class' => 'backend\modules\financial\financial',
        ],
        'seek' => [
            'class' => 'backend\modules\seek\SeekModule',
        ],
        'recharge' => [
            'class' => 'backend\modules\recharge\RechargeModule',
        ],
        'weekly' => [
            'class' => 'backend\modules\weekly\WeeklyModule',
        ],
        'exciting' => [
            'class' => 'backend\modules\exciting\ExcitingModule',
        ],
        'dating' => [
            'class' => 'backend\modules\dating\DatingModule',
        ],
        'flop' => [
            'class' => 'backend\modules\flop\FlopModule',
        ],

        'admin' => [
            'class' => 'mdm\admin\Module',
        ],

        'good' => [
            'class' => 'backend\modules\good\good',
            'aliases'   =>  [
            ],
        ],
        'active' => [
            'class' => 'backend\modules\active\active',
        ],

    ],
    'components' => [
        'db' => $db,
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'urlManager' => [
                    'class' => 'yii\web\UrlManager',
                    'enablePrettyUrl' => true,
                    'showScriptName' => false,
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
    'as access' => [
        'class' => 'backend\modules\rbac\components\AccessControl',
        'allowActions' => [
            'site/login',
            'site/logout',
            'site/error',
            //'rbac/*'
            // The actions listed here will be allowed to everyone including guests.
        ]
    ],
    'params' => $params,
];
