<?php

return [
    'components' => [
        'impulse' => [
            'class' => '\app\impulse\components\Impulse',
        ],
        'i18n' => [
            'translations' => [
                'app.impulse' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/impulse/messages',
                    'fileMap' => [
                        'crimea.impulse' => 'crimea.impulse.php',
                    ],
                ],
            ],
        ],
    ],
];
