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
class SmartWizardAsset extends AssetBundle
{
    // public $sourcePath = '@vendor/techlab/smartwizard/dist';
    public $sourcePath = '@npm/smartwizard/dist';
    public $css = [
        'css/smart_wizard_all.css',
    ];
    public $js = [
        'js/jquery.smartWizard.min.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
        // 'yii\web\YiiAsset',
        // 'yii\bootstrap4\BootstrapAsset',
    ];
}
