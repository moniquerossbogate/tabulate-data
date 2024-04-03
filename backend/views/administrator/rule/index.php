<?php

use yii\helpers\Html;
// use yii\grid\GridView;
use kartik\grid\GridView;
use yii\widgets\Pjax;

/* @var $this  yii\web\View */
/* @var $model mdm\admin\models\BizRule */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $searchModel mdm\admin\models\searchs\BizRule */

$this->title = '';
$this->params['breadcrumbs'][] = Yii::t('rbac-admin', 'Rules');
?>
<div class="rule-index">
    <p>
        <?= Html::a(Yii::t('rbac-admin', 'Create Rule'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\SerialColumn',
                'contentOptions' => ['class' => 'kartik-sheet-style'],
                'width' => '36px',
                'header' => '',
                'headerOptions' => ['class' => 'kartik-sheet-style']
            ],
            [
                'attribute' => 'name',
                'label' => Yii::t('rbac-admin', 'Name'),
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'dropdown' => true,
                'dropdownMenu' => ['class' => 'text-left']
            ],
        ],
        'responsive' => true,
        'hover' => true,
        'condensed' => true,
        'pjax' => true,
        'floatHeader' => false,
        'panel' => [
            'type' => GridView::TYPE_DARK,
            'heading' => '<i class="fas fa-scroll"></i> Rules'
        ],
        'toolbar' => [
            [
                'content' => Html::a('Create New  <i class="fas fa-plus"></i>', ['create'], ['class' => 'btn btn-sm btn-success'])
            ],
            '{export}',
            '{toggleData}'
        ],
        'exportConfig' => [
            GridView::EXCEL => [],
            GridView::HTML => [],
        ],
        'toggleDataContainer' => ['class' => 'btn-group btn-group-sm ml-1'],
        'exportContainer' => ['class' => 'btn-group-sm ml-1']
    ]);
    ?>
</div>