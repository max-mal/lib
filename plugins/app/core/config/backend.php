<?php
return [
    'bootstrap' => [
        \app\core\Bootstrap::class
    ],
    'components' => [
        'urlManager' => [
            
        ],

        'assetManager' => [
            'linkAssets' => true,
            'forceCopy' => true
        ],
    ],

    'modules' => [
        'core' => [
            'class' => \yii\base\Module::class,
            'controllerNamespace' => 'app\core\backend\controllers',
            'viewPath' => '@app/core/backend/views',
        ],
    ],
];
