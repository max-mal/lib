<?php

return [
    'basePath' => dirname(__DIR__), // @project
    'applications' => [
        'frontend' => \yupe\web\Application::class,
        'backend' => \yupe\web\Application::class,
        'manage' => \yupe\web\Application::class,
        'api' => \yupe\web\Application::class,
        'console' => \yupe\console\Application::class,
    ],
];
