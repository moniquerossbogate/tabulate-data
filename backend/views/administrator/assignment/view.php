<?php

use mdm\admin\AnimateAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\YiiAsset;

/* @var $this yii\web\View */
/* @var $model mdm\admin\models\Assignment */
/* @var $fullnameField string */

$userName = $model->{$usernameField};
if (!empty($fullnameField)) {
    $userName .= ' (' . ArrayHelper::getValue($model, $fullnameField) . ')';
}
$userName = Html::encode($userName);

$this->title = '';

$this->params['breadcrumbs'][] = ['label' => Yii::t('rbac-admin', 'Assignments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $userName;

AnimateAsset::register($this);
// YiiAsset::register($this);
$opts = Json::htmlEncode([
    'items' => $model->getItems(),
]);
$this->registerJs("var _opts = {$opts};");
$this->registerJs($this->render('_script.js'));
$animateIcon = ' <i class="spinner-border spinner-border-sm"></i>';
?>
<div class="assignment-index">
    <div class="row">
        <div class="col-sm-5">
            <input class="form-control search" data-target="available" placeholder="<?= Yii::t('rbac-admin', 'Search for available'); ?>">
            <select multiple size="20" class="form-control list" data-target="available">
            </select>
        </div>
        <div class="col-sm-2">
            <br><br>
            <?= Html::a('Assign &gt;&gt;' . $animateIcon, ['assign', 'id' => (string) $model->id], [
                'class' => 'btn btn-success btn-assign btn-block',
                'data-target' => 'available',
                'title' => Yii::t('rbac-admin', 'Assign'),
            ]); ?>
            <?= Html::a('&lt;&lt; Revoke' . $animateIcon, ['revoke', 'id' => (string) $model->id], [
                'class' => 'btn btn-danger btn-assign btn-block',
                'data-target' => 'assigned',
                'title' => Yii::t('rbac-admin', 'Remove'),
            ]); ?>
        </div>
        <div class="col-sm-5">
            <input class="form-control search" data-target="assigned" placeholder="<?= Yii::t('rbac-admin', 'Search for assigned'); ?>">
            <select multiple size="20" class="form-control list" data-target="assigned">
            </select>
        </div>
    </div>
</div>