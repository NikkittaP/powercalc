<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Переменные';
?>

<div class="row">
<div class="col-sm-3"></div>
<div class="col-sm-6">

    <?php
    $gridColumns[] = [
        'attribute' => 'id'
    ];
    $gridColumns[] = [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'name',
        'readonly' => false,
        'editableOptions' => [
            'asPopover' => false,
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            'options' => [
                'class' => 'form-control input-sm',
            ],
        ],
        'hAlign' => 'center',
        'vAlign' => 'center',
    ];
    $gridColumns[] = [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'value',
        'readonly' => false,
        'editableOptions' => [
            'asPopover' => false,
            'inputType' => \kartik\editable\Editable::INPUT_TEXT,
            'options' => [
                'class' => 'form-control input-sm',
            ],
        ],
        'hAlign' => 'center',
        'vAlign' => 'center',
    ];

    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => $gridColumns,
        'toolbar' => [
            [
                'content'=>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/constants/create'], ['class'=>'btn btn-success'])
            ],
        ],
        'striped' => true,
        'responsive' => true,
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Переменные',
        ],
    ]);
    ?>
</div>
</div>