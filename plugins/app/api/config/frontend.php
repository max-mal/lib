<?php
return [
   
    'modules' => [
        'api' => [
            'class' => \yii\base\Module::class,
            'controllerNamespace' => 'app\api\controllers',
            'viewPath' => '@app/api/views',
        ],
    ],
];
