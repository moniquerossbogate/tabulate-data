<?php

/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class DualListBoxAsset extends AssetBundle
{
    public $sourcePath = '@bower/bootstrap-duallistbox/dist';
    public $css = [
        'bootstrap-duallistbox.css',
    ];
    public $js = [
        'jquery.bootstrap-duallistbox.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
    ];
}
