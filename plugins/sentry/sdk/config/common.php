<?php

$config = [
    'components' => [
        'i18n' => [
            'translations' => [
                'sentry.sdk' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@sentry/sdk/messages',
                    'fileMap' => [
                        'sentry.sdk' => 'sentry.sdk.php'
                    ],
                ],
            ],
        ],
    ],
];

return $config;
