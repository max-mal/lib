<?php
namespace sentry\sdk;

use platform\BasePlugin;
use Yii;

class Plugin extends BasePlugin
{
    protected $version = '1.0';

    public function getName()
    {
        return Yii::t('sentry.sdk', 'Sentry');
    }

    public function getDescription()
    {
        return Yii::t('sentry.sdk', 'Sentry SDK для мониторинга ошибок');
    }

    public function getSettings()
    {
        return [
            'sentry' => [
                'items' => [
                    'frontendDsn' => [
                        'label' => 'Frontend DSN',
                        'default' => $this->getFrontendDsn(),
                    ],
                ],
            ],
        ];
    }

    public function getFrontendDsn()
    {
        return Yii::$app->settings->get($this->id, 'frontendDsn', '');
    }
}
