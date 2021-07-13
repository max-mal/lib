<?php

namespace platform\components;

use Yii;
use platform\Plugin;
use yii\base\Component;
use yii\helpers\ArrayHelper;

class PluginManager extends Component
{
    
    public function getList()
    {
        $plugins = ArrayHelper::merge(
            require Yii::getAlias('@project') . '/configs/plugins.php',
            require Yii::getAlias('@project') . '/configs/plugins-local.php'
        );

        $plugins = array_filter($plugins, function ($state) {
            return $state;
        });

        return $plugins;
    }

    public function getNavigation()
    {
        $navigation = [];

        $platformPlugin = new Plugin();
        $navigation = $platformPlugin->getNavigation();

        foreach ($this->getList() as $pluginName => $state) {
            $pluginClassName = "\\" . str_replace('/', '\\', $pluginName) . "\\Plugin";
            if (!class_exists($pluginClassName)) {
                continue;
            }
            $plugin = new $pluginClassName();

            $navigation = ArrayHelper::merge($navigation, $plugin->getNavigation());
        }

        return $navigation;
    }

    public function getSettings()
    {
        $settings = [];

        $platformPlugin = new Plugin();
        $settings['platform'] = $platformPlugin->getSettings();

        foreach ($this->getList() as $pluginName => $state) {
            $pluginClassName = "\\" . str_replace('/', '\\', $pluginName) . "\\Plugin";
            if (!class_exists($pluginClassName)) {
                continue;
            }
            $plugin = new $pluginClassName();

            $pluginSettings = $plugin->getSettings();

            // foreach ($pluginSettings as $key => $value) {
            //     $pluginSettings[$key]['plugin'] = $pluginName;
            // }
            $settings[$pluginName] = $pluginSettings;
        }



        return $settings;
    }
}
