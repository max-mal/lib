<?php

return [
    'aliases' => [
        '@frontendUrl' => 'http://project.local',
        '@backendUrl' => 'http://project.local/backend',
        '@staticUrl' => 'http://project.local/static',
    ],
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=yupe',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'enableSchemaCache' => false,
        ],
        'cache' => [
            'class' => '\yii\caching\DummyCache'
        ]
    ],
];
