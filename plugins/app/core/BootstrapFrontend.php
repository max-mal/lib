<?php
namespace app\core;

use Yii;
use yii\base\Application;
use yii\base\BootstrapInterface;
use app\core\assets\QueueAsset;
use platform\models\User;

class BootstrapFrontend implements BootstrapInterface
{
    /**
     * @param Application $app the application currently running
     */
    public function bootstrap($app)
    {
    }
}
