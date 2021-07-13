<?php

return [
    'bootstrap' => [
        '\\platform\\Bootstrap'
    ],
    'params' => [
       'user.passwordResetTokenExpire' => 3600,
       'bsVersion' => '4.x',
    ],
    'components' => [
       
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
            'defaultRoles' => ['guest', 'user'],
        ],
        'assetManager' => [
            'basePath' => '@project/web/static/assets',
            'baseUrl' => '@staticUrl/assets',
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            // Disable index.php
            'showScriptName' => false,
            // Disable r= routes
            'enablePrettyUrl' => true,

            'rules' => [
                '/profile' => '/platform/user/profile',
                '/logout' => '/platform/site/logout',
                '/login' => '/platform/site/login',
            ],
        ],
        'settings' => [
            'class' => platform\components\Settings::class,
        ],
        'pluginManager' => [
            'class' => platform\components\PluginManager::class,
        ],
        'userManager' => [
            'class' => platform\components\UserManager::class,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'i18n' => [
            'translations' => [
                'yii2mod.user' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/user/messages',
                ],
                'yii2mod.rbac' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@yii2mod/rbac/messages',
                ],
            ],
        ],
    ]
];
