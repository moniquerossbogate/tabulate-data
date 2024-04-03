<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Merge $model */

?>
<div class="merge-create">

    <h1>
        <?= Html::encode($this->title) ?>
    </h1>

    <?= $this->render('_form', [
        'model' => $model,
        'options' => $options,
    ]) ?>

</div>