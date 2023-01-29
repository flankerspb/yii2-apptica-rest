<?php

$basePath = dirname(__DIR__);

return [
    'timeZone'    => 'UTC',
    'basePath'    => $basePath,
    'runtimePath' => "$basePath/.runtime",
    'bootstrap'   => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
        '@logs'  => '@app/.logs',
    ],
    'components'  => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    ],
    'params'      => require __DIR__ . '/params.php',
];
