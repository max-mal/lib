<?php

namespace platform;

use Yii;
use yii\helpers\ArrayHelper;

class Project
{

    public $projectDirectory = null;
    public $appName = null;
    public $enabledPlugins = [];

    function __construct($appName)
    {
        $this->projectDirectory = realpath(__DIR__   . '/../');
        $this->appName = $appName;
    }

    public function run()
    {
        $config = ArrayHelper::merge(
            [
                'aliases' => [
                    '@project' => $this->projectDirectory,
                    '@app' => $this->projectDirectory . '/apps/' . $this->appName . '/',
                    '@vendor' => $this->projectDirectory . '/vendor',
                    '@runtime' => $this->projectDirectory . '/runtime/' . $this->appName,
                    '@web' => $this->projectDirectory . '/web/',
                    '@webroot' => $this->projectDirectory . '/web/',
                    '@bower' => $this->projectDirectory . '/vendor/bower-asset/',
                    '@npm' => $this->projectDirectory . '/vendor/npm-asset/'
                ],
                'layout' => '@app/views/layouts/main',
                
            ],
            $this->getAppConfig(),
            $this->getPluginsConfig()
        );


        if ($this->appName === 'console') {
            return (new \yii\console\Application($config))->run();
        }

        return (new \yii\web\Application($config))->run();
    }

    public function getPluginsConfig()
    {
        Yii::setAlias('@platform', $this->projectDirectory . '/platform');

        $this->enabledPlugins = ArrayHelper::merge(
            require $this->projectDirectory . '/configs/plugins.php',
            require $this->projectDirectory . '/configs/plugins-local.php'
        );

        $this->enabledPlugins = array_filter($this->enabledPlugins, function ($state) {
            return $state;
        });

        foreach ($this->enabledPlugins as $pluginName => $state) {
            $vendor = explode('/', $pluginName)[0];
            Yii::setAlias('@' . $vendor, $this->projectDirectory . '/plugins/' . $vendor);
            Yii::setAlias('@' . $pluginName, $this->projectDirectory . '/plugins/' . $pluginName);
        }

        $configs = [];
        foreach ($this->enabledPlugins as $pluginName => $state) {
            $configFileName = $this->projectDirectory . '/plugins/' . $pluginName . '/config/' . $this->appName . '.php';
            if (file_exists($configFileName)) {
                $configs[] = require $configFileName;
            }

            $configFileName = $this->projectDirectory . '/plugins/' . $pluginName . '/config/common.php';
            if (file_exists($configFileName)) {
                $configs[] = require $configFileName;
            }
        }

        $configFileName = $this->projectDirectory . '/platform/config/' . $this->appName . '.php';
        if (file_exists($configFileName)) {
            $configs[] = require $configFileName;
        }

        $configFileName = $this->projectDirectory . '/platform/config/common.php';
        if (file_exists($configFileName)) {
            $configs[] = require $configFileName;
        }
            
        if (!count($configs)) {
            return [];
        }

        if (count($configs) === 1) {
            return $configs[0];
        }

        return call_user_func_array('\yii\helpers\ArrayHelper::merge', $configs);
    }

    public function getAppConfig()
    {
        $configs = [];

        $configs[] = require $this->projectDirectory . '/configs/main.php';
        if (file_exists($this->projectDirectory . '/configs/main-local.php')) {
            $configs[] = require $this->projectDirectory . '/configs/main-local.php';
        }

        $configs[] = require $this->projectDirectory . '/configs/' . $this->appName . '/main.php';
        if (file_exists($this->projectDirectory . '/configs/' . $this->appName . '/main-local.php')) {
            $configs[] = require $this->projectDirectory . '/configs/' . $this->appName . '/main-local.php';
        }

        return call_user_func_array('\yii\helpers\ArrayHelper::merge', $configs);
    }
}
