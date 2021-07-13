<?php

namespace app\impulse\backend\assets;

use yii\web\AssetBundle;
use yii\web\JqueryAsset;

class ImpulseAsset extends AssetBundle
{
    public $sourcePath = '@app/impulse/backend/assets/impulse';

    public $js = [
        'moment_locales.min.js',
        'daterangepicker.js',
    ];

    public $css = [
        'daterangepicker.css',
    ];

    public $depends = [
        JqueryAsset::class,
    ];
}
