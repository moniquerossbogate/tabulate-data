<?php
/**
 * author     : forecho <caizhenghai@gmail.com>
 * createTime : 2016/5/16 19:51
 * description:
 */

namespace app\assets;

use yii\web\AssetBundle;

class ChartAsset extends AssetBundle
{
    public $sourcePath = '@bower/chart.js/dist'; // Path to Chart.js source files
    public $js = [
        'chart.min.js', // Chart.js minified JavaScript file
    ];
    public $depends = [
        'yii\web\YiiAsset', // Yii's built-in asset
    ];
}