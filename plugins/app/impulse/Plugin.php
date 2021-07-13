<?php
namespace app\impulse;

use Yii;
use platform\BasePlugin;

class Plugin extends BasePlugin
{
    public $core = true;
    protected $version = '1.0';

    public function getName()
    {
        return Yii::t('app.impulse', 'Impulse');
    }

    public function getDescription()
    {
        return Yii::t('app.impulse', 'Логирование действий');
    }

    public function getNavigation()
    {
        return [
            'impulse' => [
                'label' => 'Лог событий',
                'url' => ['/impulse/air/index'],
                'icon' => 'fa fa-fw fa-bars',
            ],
        ];
    }
}
