<?php
return [
    'bootstrap' => [
        \app\core\BootstrapFrontend::class
    ],
    'defaultRoute' => '/core/index',

    'components' => [
        'urlManager' => [
            'rules' => [
                '/link/book/<id:\d+>' => '/core/link/book',
                '/link/author/<id:\d+>' => '/core/link/author',                
            ],
        ],
    ],

    'modules' => [
        'core' => [
            'class' => \yii\base\Module::class,
            'controllerNamespace' => 'app\core\frontend\controllers',
            'viewPath' => '@app/core/frontend/views',
        ],
    ],
    'as access' => [
        'class' => yii2mod\rbac\filters\AccessControl::class,
        'allowActions' => [
            'platform/site/*',
            'core/index/create-admin',
            'planfix/webhook/*',
            'gitlab/webhook/*',
            'core/index/version',
            'core/index/version-history',
            'update/log/remote',
        ],
        'rules' => [
            // allow authenticated users
            [
                'allow' => true,
                'roles' => ['admin'],
            ],
        ],
    ],
];
