<?php

namespace sentry\sdk\assets;

use sentry\sdk\Plugin;
use yii\web\AssetBundle;
use Yii;

class SentryAsset extends AssetBundle
{
    public $sourcePath = '@sentry/sdk/assets/sentry';
    public $js = [
        'sentry.js',
        'main.js',
    ];

    public function init()
    {
        parent::init();
        $this->writeFile();
    }

    public function writeFile()
    {
        $dsn = Plugin::getInstance()->getFrontendDsn();
        $filename = Yii::getAlias($this->sourcePath . '/main.js');

        if (!$dsn) {
            if (file_exists($filename)) {
                unlink($filename);
            }
            
            return false;
        }
        
        if (file_exists($filename)) {
            return true;
        }
        
        file_put_contents(
            $filename,
            "Sentry.init({ dsn: '$dsn' });"
        );
    }
}
