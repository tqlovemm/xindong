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
        'apps' => [
            'class' => 'backend\modules\apps\apps',
        ],
        'male' => [
            'class' => 'backend\modules\male\male',
        ],
        'app' => [
            'class' => 'backend\modules\app\App',
        ],
        'setting' => [
            'class' => 'backend\modules\setting\SettingModule',
        ],
        'collecting-file' => [
            'class' => 'backend\modules\collecting\Collecting',
        ],
        'financial' => [
            'class' => 'backend\modules\financial\financial',
            'aliases'   =>  [
                '@financial' => '@backend/modules/financial',
            ],
        ],
        'vip' => [
            'class' => 'backend\modules\vip\vip',
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
        'note' => [
            'class' => 'backend\modules\note\NoteModule',
        ],

        'good' => [
            'class' => 'backend\modules\good\good',
            'aliases'   =>  [
            ],
        ],
        'card' => [
            'class' => 'backend\modules\card\card',
        ],
        'active' => [
            'class' => 'backend\modules\active\active',
        ],
        'article' => [
            'class' => 'backend\modules\article\Article',
        ],
        'saveme' => [
            'class' => 'backend\modules\saveme\Saveme',
        ],
        'authentication' => [
            'class' => 'backend\modules\authentication\GirlAuthentication',
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

    'on beforeRequest' => function($event) {
        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_INSERT, ['backend\components\AdminLog', 'write']);
        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_UPDATE, ['backend\components\AdminLog', 'write']);
        \yii\base\Event::on(\yii\db\BaseActiveRecord::className(), \yii\db\BaseActiveRecord::EVENT_AFTER_DELETE, ['backend\components\AdminLog', 'write']);
    },
];
