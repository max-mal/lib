<?php

namespace app\core;

use Yii;
use yii\base\BootstrapInterface;
use yii\helpers\VarDumper;

class CronBootstrap implements BootstrapInterface
{
    /**
     * @inheritDoc
     */
    public function bootstrap($app)
    {
        if ($app->has('schedule') && $schedule = $app->get('schedule')) {
        }
    }
}
