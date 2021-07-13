<?php
return [
    'layout' => '@platform/layouts/backend',
    'defaultRoute' => '/platform/settings/index',
    'components' => [
         'user' => [
            'class' => yii\web\User::class,
            'identityClass' => 'platform\models\User',
            // for update last login date for user, you can call the `afterLogin` event as follows
            'on afterLogin' => function ($event) {
                $event->identity->updateLastLogin();
            },
            'loginUrl' => ['/platform/site/login'],
         ],
    ],
    'modules' => [
        'platform' => [
            'class' => \yii\base\Module::class,
            'controllerNamespace' => 'platform\controllers',
            'viewPath' => '@platform/views',
        ],
        'rbac' => [
            'class' => 'yii2mod\rbac\Module',
        ],
    ],
    'as access' => [
        'class' => yii2mod\rbac\filters\AccessControl::class,
        'allowActions' => [
            'platform/site/*'
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
