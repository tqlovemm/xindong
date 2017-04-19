<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
$db = require(__DIR__ . '/../../common/config/db.php');
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),    
    'bootstrap' => ['log'],
    'modules' => [
        'v2' => [
            'basePath' => '@app/modules/v2',
            'class' => 'api\modules\v2\Module'
        ],
        'v3' => [
            'basePath' => '@app/modules/v3',
            'class' => 'api\modules\v3\Module'
        ],
        'v4' => [
            'basePath' => '@app/modules/v4',
            'class' => 'api\modules\v4\Module'
        ],
        'v5' => [
            'basePath' => '@app/modules/v5',
            'class' => 'api\modules\v5\Module'
        ],
        'v6' => [
            'basePath' => '@app/modules/v6',
            'class' => 'api\modules\v6\Module'
        ],
        'v7' => [
            'basePath' => '@app/modules/v7',
            'class' => 'api\modules\v7\Module'
        ],
        'v8' => [
            'basePath' => '@app/modules/v8',
            'class' => 'api\modules\v8\Module'
        ],
        'v9' => [
            'basePath' => '@app/modules/v9',
            'class' => 'api\modules\v9\Module'
        ],
        'v10' => [
            'basePath' => '@app/modules/v10',
            'class' => 'api\modules\v10\Module'
        ],
        'v11' => [
            'basePath' => '@app/modules/v11',
            'class' => 'api\modules\v11\Module'
        ],

    ],
    'components' => [
        'db' => $db,
        'user' => [
            'identityClass' => 'api\modules\v11\models\User',
            'enableAutoLogin' => true,
            'enableSession' => false,
            'loginUrl'=>null,
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
        'urlManager' => [
            'enablePrettyUrl' => true,
            /*'enableStrictParsing' => true,*/
            'showScriptName' => false,
            'rules' => [
                [
                    'class' => 'yii\rest\UrlRule', 
                    'controller' => [
                      'v2/thread','v2/user','v2/user1','v2/post','v2/profile','v2/data','v2/mark','v2/ufollow','v2/note','v2/follow','v2/claims-thread',
                        'v2/flop','v2/flop-content','v2/flop-content-data',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                      'v3/dating','v3/dating-content','v3/dating-comment','v3/date','v3/version','v3/push','v3/heartweek','v3/slide-content',
                        'v3/heartweek-comment','v3/app-push','v3/heart-story','v3/thread','v3/login','v3/user',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                      'v4/member','v4/area','v4/recharge-record','v4/predefined-jiecao-coin','v4/member-sorts','v4/dating-signup','v4/user','v4/complaint','v4/app-recharge-verify',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v5/member','v5/dating-signup','v5/member-sort','v5/order','v5/user','v5/refund',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],

                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v6/member-info','v6/user-info','v6/user-info-img','v6/make-friend','v6/dating','v6/user-dating','v6/group',
                        'v6/area','v6/word','v6/update-user-info','v6/reply','v6/reply2','v6/self-dating','v6/update-user-info2',
                        'v6/dating-need-coin','v6/member-sort','v6/member','v6/cellphone'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v7/predefined-jiecao-coin','v7/member-sort','v7/like','v7/user','v7/accusation','v7/message','v7/message2','v7/app-push','v7/user2',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v8/member-sort','v8/user','v8/user2','v8/member-sort2','v8/user3','v8/hx-group','v8/hx-group2','v8/dating','v8/order','v8/recharge-record',
                        'v8/user-info','v8/order-second','v8/ordere',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v9/member-sort','v9/member-sort2','v9/member-sort3','v9/turn-over-card','v9/user-info','v9/judge','v9/turn-over-card-match',
                        'v9/user-info','v9/dating','v9/send-msg','v9/check-user-info','v9/dating-signup','v9/area'
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v10/user','v10/make-friend','v10/turn-over-card','v10/login','v10/ufollow','v10/follow','v10/member-sort','v10/word',
                        'v10/like','v10/cellphone','v10/dating-signup','v10/user2','v10/user3','v10/user4','v10/dating','v10/member','v10/recharge-record',
                        'v10/change-user-info','v10/match','v10/judge','v10/message','v10/message2','v10/judge','v10/member2',
                        'v10/user-info','v10/accusation','v10/order','v10/reply','v10/user-info','v10/user5','v10/get-info','v10/user-login',
                        'v10/register','v10/third-party','v10/member-sort-second',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
                [
                    'class' => 'yii\rest\UrlRule',
                    'controller' => [
                        'v11/saveme','v11/saveme-comment','v11/saveme-info','v11/form-thread','v11/form','v11/form-thread-comments','v11/form-thread-thumbs-up','v11/form-thread-tag',
                    ],
                    'tokens' => [
                        '{id}' => '<id:\\w+>',

                    ]
                ],
            ],
        ]
    ],
    'params' => $params,
];



