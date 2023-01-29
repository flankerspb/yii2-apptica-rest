<?php

return [
    'components' => [
        'db'     => [
            'class'    => 'yii\db\Connection',
            'dsn'      => 'mysql:host=localhost;dbname=rest',
            'username' => 'root',
            'password' => '',
            'charset'  => 'utf8',
        ],
        // 'mailer' => [
        //     'class'            => \yii\symfonymailer\Mailer::class,
        //     'useFileTransport' => true,
        // ],
    ],
];
