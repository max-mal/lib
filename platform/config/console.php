<?php
return [
    'bootstrap' => ['log', 'queue'],
    'modules' => [
        'user' => [
            'class' => 'yii2mod\user\ConsoleModule',
        ],

        'platform' => [
            'class' => \yii\base\Module::class,
            'controllerNamespace' => 'platform\controllers',
            'viewPath' => '@platform/views',
        ],
    
    ],
    'components' => [
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => \yii\log\DbTarget::class,
                    'levels' => ['error', 'warning'],
                    'logTable' => 'yii_console'
                ],
            ],
        ],
        'urlManager' => [
            'baseUrl' => 'https://app.poravinternet.ru',
            'hostInfo' => '/',
        ],
        'schedule' => \omnilight\scheduling\Schedule::class,
        
    ],
    'controllerMap' => [
        // ...
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => null,
            'migrationNamespaces' => [
                // ...
                'yii\queue\db\migrations',
                

            ],
        ],
    ],
];
