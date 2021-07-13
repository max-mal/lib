<?php
namespace app\core;

use yii\base\Application;
use yii\base\BootstrapInterface;
use yii\db\Connection;
use yii\db\Exception;

class TimezoneBootstrap implements BootstrapInterface
{
    /**
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
        $app->db->on(Connection::EVENT_AFTER_OPEN, function ($event) {
            /* @var $db \yii\db\Connection */
            $db = $event->sender;

            try {
                $db->createCommand('SET time_zone=:time_zone;', [':time_zone' => date('P')])->execute();
            } catch (Exception $e) {

            }
        });
    }
}
