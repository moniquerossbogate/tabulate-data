<?php

namespace app\assets;

use yii\web\AssetBundle;

class DevThemeAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'scss/site.scss',
    ];
    public $js = [];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
