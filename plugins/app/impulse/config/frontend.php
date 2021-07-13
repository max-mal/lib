<?php

return [
    'bootstrap' => [
        '\app\impulse\frontend\Bootstrap',
    ],
    'modules' => [
        'impulse' => [
            'class' => '\yii\base\Module',
            'controllerNamespace' => '\app\impulse\frontend\controllers',
        ],
    ],
];
