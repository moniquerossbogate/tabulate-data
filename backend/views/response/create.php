<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Response $model */

$this->title = 'Create Response';
$this->params['breadcrumbs'][] = ['label' => 'Responses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="response-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
