<?php

return [
    'components' => [
        'i18n' => [
            'translations' => [
                'app.api' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/api/messages',
                    'fileMap' => [
                        'app.api' => 'app.api.php'
                    ],
                ],
            ],
        ],
    ],
];
