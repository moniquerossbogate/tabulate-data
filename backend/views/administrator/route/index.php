<?php

use mdm\admin\AnimateAsset;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $routes [] */

$this->title = '';
$this->params['breadcrumbs'][] = 'Routes';

AnimateAsset::register($this);
// YiiAsset::register($this);
$opts = Json::htmlEncode([
    'routes' => $routes,
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="spinner-border spinner-border-sm"></i>';
?>
<!-- <h1><?= Html::encode($this->title); ?></h1> -->
<div class="route-administration-index">
    <div class="row">
        <div class="col-sm-12">
            <div class="input-group">
                <input id="inp-route" type="text" class="form-control" placeholder="<?= 'New Route(s)'; ?>">
                <span class="input-group-btn">
                    <?= Html::a('Add' . $animateIcon, ['create'], [
                        'class' => 'btn btn-success',
                        'id' => 'btn-new',
                    ]); ?>
                </span>
            </div>
        </div>

    </div>
    <p>&nbsp;</p>
    <div class="row">
        <div class="col-sm-5">
            <div class="input-group">
                <input class="form-control search" data-target="available" placeholder="<?= 'Search for Available'; ?>">
                <span class="input-group-btn">
                    <?= Html::a('<i class="fas fa-sync-alt"></i>', ['refresh'], [
                        'class' => 'btn btn-default',
                        'id' => 'btn-refresh',
                    ]); ?>
                </span>
            </div>
            <select multiple size="20" class="form-control list" data-target="available"></select>
        </div>
        <div class="col-sm-2">
            <br><br>
            <?= Html::a('Assign &gt;&gt;' . $animateIcon, ['assign'], [
                'class' => 'btn btn-success btn-assign btn-block',
                'data-target' => 'available',
                'title' => 'Assign',
            ]); ?>
            <?= Html::a('&lt;&lt; Remove' . $animateIcon, ['remove'], [
                'class' => 'btn btn-danger btn-assign btn-block',
                'data-target' => 'assigned',
                'title' => 'Remove',
            ]); ?>
        </div>
        <div class="col-sm-5">
            <input class="form-control search" data-target="assigned" placeholder="<?= 'Search for Assigned'; ?>">
            <select multiple size="20" class="form-control list" data-target="assigned"></select>
        </div>
    </div>
</div>