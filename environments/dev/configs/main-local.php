<?php

return [
    'aliases' => [
        '@frontendUrl' => '',
        '@backendUrl' => '',
        '@staticUrl' => '',
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
            'class' => \yii\caching\DummyCache::className()
        ]
    ],
];
