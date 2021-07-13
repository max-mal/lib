<?php

$config = [
    'id' => 'lib',
    'basePath' => realpath(__DIR__ . '/../'),
    'name' => 'Lib',
    'timeZone' => 'Europe/Moscow',
    'language' => 'ru-RU',    
    'components' => [
        'formatter' => [
            'defaultTimeZone' => 'Europe/Moscow',
            'nullDisplay' => '',
            'numberFormatterOptions' => [
                NumberFormatter::MIN_FRACTION_DIGITS => 0,
                NumberFormatter::MAX_FRACTION_DIGITS => 2,
            ],
        ],
        'gitlab' => [
            'class' => \app\gitlab\components\GitlabApi::class,
            'noHooks' => false,
        ],
        'planfix' => [
            'class' => \app\planfix\components\PlanfixApi::class,
        ],
        'queue' => [
            'class' => \yii\queue\db\Queue::class,
            'db' => 'db', // DB connection component or its config
            'tableName' => '{{%queue}}', // Table name
            'channel' => 'default', // Queue channel key
            'mutex' => \yii\mutex\MysqlMutex::class, // Mutex used to sync queries
            'ttr' => 86400,
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                    'categories' => [
                        // 'yii\db\*',
                        // 'yii\web\HttpException:*',
                    ],
                    'except' => [
                        'yii\web\HttpException:404',
                    ],
                ]
            ],
        ],
       
    ]
];

if (YII_ENV_DEV) {
    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
    ];
}

return $config;
