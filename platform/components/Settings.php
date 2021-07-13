<?php

namespace platform\components;

use yii\base\Component;
use platform\models\Settings as SettingsModel;

class Settings extends Component
{
    
    public function get($namespace, $key, $default = null, $userId = null)
    {
        try {
            $settings = SettingsModel::find()->where([
                'namespace' => $namespace,
                'key' => $key,
                'user_id' => $userId
            ])->one();

            if (!$settings) {
                return $default;
            }
        } catch (\Exception $e) {
            return $default;
        }

        return unserialize($settings->value);
    }

    public function set($namespace, $key, $value, $userId = null)
    {
        $settings = SettingsModel::find()->where([
            'namespace' => $namespace,
            'key' => $key,
            'user_id' => $userId
        ])->one();

        if (!$settings) {
            $settings = new SettingsModel();
            $settings->user_id = $userId;
            $settings->namespace = $namespace;
            $settings->key = $key;
        }

        $settings->value = serialize($value);
        return $settings->save();
    }
}
