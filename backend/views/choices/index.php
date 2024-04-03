<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap4\Modal;
use kartik\grid\GridView;

use hoaaah\ajaxcrud\BulkButtonWidget;
use johnitvn\ajaxcrud\CrudAsset;


CrudAsset::register($this);
$this->title = '';
$this->params['breadcrumbs'][] = ['label' => 'Choices', 'url' => ['index']];
?>
<div class="component-index">
    <div id="ajaxCrudDatatable">
        <?= GridView::widget([
            'id' => 'crud-datatable',
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'pjax' => true,
            'columns' => require(__DIR__ . '/_columns.php'),
            'toolbar' => [
                [
                    'content' =>
                    Html::a(
                        '<i class="fas fa-plus"></i>',
                        ['create'],
                        ['role' => 'modal-remote', 'title' => 'Create new Choices', 'class' => 'btn btn-default btn-sm']
                    ) .
                    Html::a('<i class="fas fa-redo-alt"></i>', ['',], ['data-pjax' => 1, 'class' => 'btn btn-sm btn-default', 'title' => 'Reset Grid']) .
                    '{toggleData}' .
                    '{export}'
                ],
            ],
            'striped' => true,
            'condensed' => true,
            'responsive' => true,
            'panel' => [
                'type' => 'primary',
                'heading' => '<i class="glyphicon glyphicon-list"></i> Add Choices',
                'before' => '<em>* Resize table columns just like a spreadsheet by dragging the column edges.</em>',

                '<div class="clearfix"></div>',
            ],

            'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
            'exportContainer' => ['class' => 'btn-group-sm ml-1']
        ]) ?>

    </div>
</div>
<?php
Modal::begin([
    "id" => "ajaxCrudModal",
    "size" => "modal-lg",
    "footer" => "", // always need it for jquery plugin
])
    ?>
<?php
Modal::end();

Modal::begin([
    'id' => 'modal-view',
    'size' => 'modal-lg',

]);

Modal::end();
?>


<style>
.modal-header {
    background-color: #212529;
    color: #fff;
}
</style>