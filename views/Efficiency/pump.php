<?php

use yii\helpers\Html;
use kartik\grid\GridView;

$this->title = 'Заполнение данных для таблицы КПД насоса';
?>

<div class="row">
<div class="col-sm-3"></div>
<div class="col-sm-6">

    <?php
    $gridColumns[] = [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'QCurQmax',
        'readonly' => false,
        'format' => ['decimal', 4],
        'editableOptions' => [
            'asPopover' => false,
            'header' => 'Qтек/Qmax',
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'class' => 'form-control input-sm',
                'pluginOptions' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.0001,
                    'decimals' => 4,
                    'verticalbuttons' => true,
                ]
            ],
        ],
        'hAlign' => 'center',
        'vAlign' => 'center',
    ];

    $gridColumns[] = [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'pumpEfficiency',
        'readonly' => false,
        'format' => ['decimal', 4],
        'editableOptions' => [
            'asPopover' => false,
            'header' => 'КПД насоса',
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'class' => 'form-control input-sm',
                'pluginOptions' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.0001,
                    'decimals' => 4,
                    'verticalbuttons' => true,
                ]
            ],
        ],
        'hAlign' => 'center',
        'vAlign' => 'center',
    ];

    $gridColumns[] = [
        'class' => 'kartik\grid\EditableColumn',
        'attribute' => 'pumpEfficiencyRK',
        'readonly' => false,
        'format' => ['decimal', 4],
        'editableOptions' => [
            'asPopover' => false,
            'header' => 'КПД насоса + РК',
            'inputType' => \kartik\editable\Editable::INPUT_SPIN,
            'options' => [
                'class' => 'form-control input-sm',
                'pluginOptions' => [
                    'min' => 0,
                    'max' => 1,
                    'step' => 0.0001,
                    'decimals' => 4,
                    'verticalbuttons' => true,
                ]
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
                'content' =>
                    Html::a('<i class="glyphicon glyphicon-plus"></i>', ['/efficiency/createpump'], ['class' => 'btn btn-success'])
            ],
        ],
        'striped' => true,
        'responsive' => true,
        'condensed' => true,
        'hover' => true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Заполнение данных для таблицы КПД насоса',
        ],
    ]);

    if ($dataProvider->getCount() == 0)
        echo Html::a('Загрузить предустановленные значения', ['/efficiency/loaddefaults'], ['class' => 'btn btn-success']);
    ?>
</div>
</div>