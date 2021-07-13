<?php
namespace platform\assets;

/**
 *
 */
class SBAdminAsset extends \yii\web\AssetBundle
{
    public $sourcePath = '@platform/assets/SBAdmin';
    public $css = [
        'https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i',
        'sb-admin.css',
    ];
    public $js = [
        'jq-easing.js',
        'sb-admin.js'
    ];

    public $depends = [
        \yii\bootstrap4\BootstrapPluginAsset::class,
        \rmrevin\yii\fontawesome\AssetBundle::class,
        // \kartik\icons\FontAwesomeAsset::class, // SVG icons
        GlyphiconsAsset::class,
    ];
}
