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
            'enableSchemaCache' => true,
        ],
        'cache' => [
            'class' => \yii\caching\FileCache::className(),
            'cachePath' => '@project/runtime/cache',
        ]
    ],
];
