<?php

use app\models\User;
use yii\web\JsonResponseFormatter;
use yii\web\JsonParser;
use yii\web\Response;

$config = [
    'id'                  => 'api',
    'controllerNamespace' => 'app\controllers',
    'components'          => [
        'request'    => [
            'parsers'                => [
                'application/json' => JsonParser::class,
            ],
            'enableCsrfValidation'   => false,
            'enableCsrfCookie'       => false,
            'enableCookieValidation' => false,
        ],
        'user'       => [
            'identityClass'   => User::class,
            'enableAutoLogin' => false,
            'enableSession'   => false,
            'loginUrl'        => null,
        ],
        'log'        => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets'    => [
                [
                    'class'   => 'yii\log\FileTarget',
                    'logFile' => '@app/.logs/web.log',
                    'levels'  => ['error', 'warning'],
                ],
            ],
        ],
    ],
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][]      = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        //'allowedIPs' => ['127.0.0.1', '::1'],
    ];
}

return $config;
