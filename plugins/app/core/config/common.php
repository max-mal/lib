<?php

return [
    'bootstrap' => [
        \app\core\TimezoneBootstrap::class
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'app.core' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/core/messages',
                    'fileMap' => [
                        'app.core' => 'app.core.php'
                    ],
                ],
            ],
        ],
    ],
];
