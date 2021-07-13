<?php

namespace app\core\console;

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
            /** @var \omnilight\scheduling\Schedule $schedule */
            $schedule->call(function (\yii\console\Application $app) {
                Yii::$app->settings->set('app.core', 'cron-test', (string)time());
            })->everyMinute();
        }
    }
}
