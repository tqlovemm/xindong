<?php
$config =  [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'tVBIZFCqv96srhrmdvnkDCnwnImCJeoK',
        ],
    ],
];
if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment


    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}
return $config;