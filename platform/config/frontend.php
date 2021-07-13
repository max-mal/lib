<?php
return [
    'modules' => [
        'platform' => [
            'class' => \yii\base\Module::class,
            'controllerNamespace' => 'platform\controllers',
            'viewPath' => '@platform/views',
        ],
    ],
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

    'as access' => [
        'class' => yii2mod\rbac\filters\AccessControl::class,
        'allowActions' => [
            'api/*'
        ],
        'rules' => [
            // allow authenticated users
            [
                'allow' => true,
                'roles' => ['?'],
            ],
        ],
    ],
];
