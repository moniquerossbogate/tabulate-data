<?php

use kartik\detail\DetailView as DetailDetailView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\UserProfile */

$this->title = $model->firstname . ' ' . $model->lastname;
$this->params['breadcrumbs'][] = ['label' => 'User Profiles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);

$attributes = [
    [
        'group' => true,
        'label' => 'Personal Information',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'columns' => [
            [
                'attribute' => 'firstname'
            ],
            [
                'attribute' => 'middlename'
            ],
            [
                'attribute' => 'lastname'
            ]
        ]
    ],
    [
        'group' => true,
        'label' => 'Contact Details',
        'rowOptions' => ['class' => 'table-info']
    ],
    [
        'group' => true,
        'label' => 'Affiliation',
        'rowOptions' => ['class' => 'table-info']
    ],
    'designation',
];

?>
<div class="user-profile-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailDetailView::widget([
        'model' => $model,
        // 'attributes' => [
        //     'model',
        //     'equipmentType.name',
        //     'equipmentCategory.name',
        //     'created_at',
        //     'updated_at',
        // ],
        'attributes' => $attributes,
        'mode' => 'view',
        'bordered' => true,
        'striped' => false,
        'condensed' => true,
        'hover' => true,
        'enableEditMode' => false,
        'tooltips' => true,
        'panel' => [
            'type' => 'primary',
            'heading' => '<i class="fas fa-user"></i> User Profile'
        ],
        'deleteOptions' => [
            'params' => ['id' => $model->id, 'kvdelete' => true],
            'url' => Url::to('delete')
        ],
        'container' => ['id' => 'kv-demo'],
        //'formOptions' => ['action' => Url::current(['delete' => 'kv-demo'])]
    ]) ?>

</div>