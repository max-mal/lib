<?php
namespace app\core;

use platform\BasePlugin;
use Yii;
use yii\helpers\Url;

class Plugin extends BasePlugin
{
    protected $version = '1.0';

    public function getName()
    {
        return Yii::t('app.core', 'Core');
    }

    public function getDescription()
    {
        return Yii::t('app.core', 'Ядро системы');
    }

    public function getNavigation()
    {
        return [
            'core' => [
                'label' => "Lib",
                'icon' => 'fa fa-fw fa-wrench',
                'url' => '#',
                'items' => [
                    [
                        'label' => 'Книги',
                        'url' => Url::to(['/core/book/index'])
                    ],
                    [
                        'label' => 'Авторы',
                        'url' => Url::to(['/core/avtor/index'])
                    ],

                ],
            ],
        ];
    }
}
