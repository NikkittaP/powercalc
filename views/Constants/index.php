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

<div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-3">
        <?php
        if ($dataProvider->getCount() == 0)
            echo Html::a('Загрузить предустановленные значения', ['/constants/loaddefaults'], ['class' => 'btn btn-success']);
        ?>
    </div>
    <div class="col-sm-3">
        <div class="pull-right">
            <?php
            echo Html::a('Очистить таблицу', ['/constants/truncate'], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => 'Вы действительно хотите очистить таблицу?',
                    'method' => 'post',
                ],
                ]);
            ?>
        </div>
    </div>
    <div class="col-sm-3"></div>
</div>