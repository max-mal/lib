<?php
namespace app\api;

use platform\BasePlugin;
use Yii;
use yii\helpers\Url;

class Plugin extends BasePlugin
{
    protected $version = '1.0';

    public function getName()
    {
        return Yii::t('app.api', 'API');
    }

    public function getDescription()
    {
        return Yii::t('app.core', 'API');
    }

}
