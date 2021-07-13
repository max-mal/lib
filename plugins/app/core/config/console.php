<?php

return [
    'bootstrap' => [
        '\app\core\CronBootstrap'
    ],
    'modules' => [
        'core' => [
            'class' => 'yii\base\Module',
            'controllerNamespace' => 'app\core\console\controllers',
        ],
    ],
];
