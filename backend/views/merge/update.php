<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Merge $model */

$this->title = 'Update Merge: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Merges', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="merge-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
