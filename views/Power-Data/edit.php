<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Редактирование данных для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'edit', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>

<div class="power-data-edit">

    <h3>Выберите группу потребителей для отображения данных по ним:</h3>
    <?php
    echo Html::beginForm(['power-data/edit', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id], 'post', ['class'=>'form-group']);
    echo Html::hiddenInput('isPost', '1');
    $items = ArrayHelper::map(app\models\ConsumerGroups::find()->all(), 'id', 'name');
    array_unshift($items,'Все');
    echo Html::dropDownList('selected_consumer_group', $selectedConsumerGroup, $items, ['class'=>'form-control', 'style'=>'width:300px;']);
    ?>
    <br />
    <div class="form-group">
        <?= Html::submitButton('Показать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>

    <?php
    $consumers = ArrayHelper::map(app\models\Consumers::find()->orderBy('name')->asArray()->all(), 'id', 'name');

    $gridColumns = [
        [
            'attribute' => 'id',
            'contentOptions' => [
                'style' => 'font-size:12px;padding:0px;margin:0px;',
            ],
            'hAlign' => 'center',
            'vAlign' => 'center',
        ],
        /*
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return Yii::$app->controller->renderPartial('_detail_view', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true,
            'width' => '50px',
        ],
        */
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'consumer_id',
            'width' => '250px',
            'contentOptions' => [
                'style' => 'min-width:250px;padding:0px;margin:0px;'
            ], 
            'readonly' => false,
            'editableOptions' => [
                'asPopover' => false,
                'header' => 'Потребитель',
                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                'data'=>$consumers,
                'displayValueConfig'=>$consumers,
                'options' => [
                    'class'=>'form-control input-sm',
                    'prompt'=>'Выберите потребителя...',
                ],
            ],
        ],
    ];

    /* Столбцы архитектур */
    $architecturesNames = app\models\ArchitecturesNames::find()->where(['id' => $usingArchitectures, 'vehicleLayoutName_id'=>$vehicleLayoutNameModel->id])->orderBy(['isBasic' => SORT_DESC, 'name' => SORT_ASC])->all();
    $energySources = ArrayHelper::map(app\models\EnergySources::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    $i=0;
    foreach ($architecturesNames as $architecturesName)
    {
        $border = '';
        $background ='';
        if ($i==0)
            $border = 'border-left:5px solid green;';
        
        if ($architecturesName->isBasic == 1)
            $background = 'background-color:#e0f0d7;';

        $style =['style' => 'min-width:80px;padding:0px;margin:0px;'.$border.$background];

        $gridColumns[] = [
            'class' => 'kartik\grid\EditableColumn',
            'attribute'=>'architectureToVehicleLayouts_'.$architecturesName->id,
            'value'=>function ($model, $key, $index, $column) use($architecturesName, $architectureToVehicleLayouts, $energySources) {
                if (!isset($architectureToVehicleLayouts[$model->id][$architecturesName->id]))
                    return '';
                return $energySources[$architectureToVehicleLayouts[$model->id][$architecturesName->id]];
            },
            'readonly' => false,
            'editableOptions' => [
                'name' => 'architectureToVehicleLayouts_'.$architecturesName->id,
                'value'=>function ($model, $key, $index, $column) use($architecturesName, $architectureToVehicleLayouts, $energySources) {
                    if (!isset($architectureToVehicleLayouts[$model->id][$architecturesName->id]))
                        return '';
                    return $energySources[$architectureToVehicleLayouts[$model->id][$architecturesName->id]];
                },
                'asPopover' => false,
                'header' => 'Энергосистема',
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'displayValueConfig'=>$energySources,
                'options' => [
                    'data'=>$energySources,
                    'class'=>'form-control input-sm',
                    'size' => 'sm',
                    'options' => [
                        'placeholder' => 'Энергосистема',
                    ],
                ],
            ],
            'contentOptions' => $style,
            'headerOptions' => $style,
            'filterOptions' => $style,
            //'width' => '10%',
            'hAlign' => 'center',
            'vAlign' => 'center',
        ];

        $i++;
    }

    /* Столбцы режимов полёта */
    $flightModes = app\models\FlightModes::find()->where(['id' => $usingFlightModes])->all();
    $i=0;
    foreach ($flightModes as $flightMode)
    {
        $border = [];
        if ($i == 0)
            $border = ['style' => 'border-left:5px solid green;'];

        $gridColumns[] = [
            'class' => 'kartik\grid\EditableColumn',
            'attribute'=>'flightModesToVehicleLayout_'.$flightMode->id,
            'value'=>function ($model, $key, $index, $column) use($flightMode, $flightModesToVehicleLayouts) {
                if (!isset($flightModesToVehicleLayouts[$model->id][$flightMode->id]))
                    return '';
                return $flightModesToVehicleLayouts[$model->id][$flightMode->id];
            },
            'readonly' => false,
            'format' => ['decimal', 2],
            'editableOptions' => [
                'name' => 'flightModesToVehicleLayout_'.$flightMode->id,
                'asPopover' => false,
                'header' => 'Коэффициент использования',
                'inputType' => \kartik\editable\Editable::INPUT_SPIN,
                'options' => [
                    'class'=>'form-control input-sm',
                    'pluginOptions' => [
                        'min' => 0,
                        'max' => 1,
                        'step' => 0.1,
                        'decimals' => 2,
                        'verticalbuttons' => true,
                        ]
                ],
            ],
            'contentOptions' => function ($model, $key, $index, $column) use($border, $flightMode, $flightModesToVehicleLayouts) {
                if (isset($flightModesToVehicleLayouts[$model->id][$flightMode->id]))
                {
                    $usageFactor = $flightModesToVehicleLayouts[$model->id][$flightMode->id];
                    $style = '';
                    $class = '';
                    if ($usageFactor == 1)
                    {
                        $style = 'background-color: #fbf9e3;';
                        $class = 'darkyellow';
                    }
                    else if ($usageFactor > 1)
                    {
                        $style = 'background-color: #f2dddd;';
                        $class = 'darkred';
                    }
                    else if ($usageFactor != 0 && $usageFactor < 1)
                        $class = 'darkred';
                    
                    if (count($border) != 0)
                        $style.='border-left:5px solid green;';

                    return ['style' => 'padding:0px;margin:0px;'.$style, 'class' => $class];
                }
            },
            'headerOptions' => $border,
            'filterOptions' => $border,
            //'width' => '10%',
            'hAlign' => 'center',
            'vAlign' => 'center',
        ];

        $i++;
    }

    echo GridView::widget([
        'dataProvider'=> $dataProvider,
        'columns' => $gridColumns,
        'toolbar' =>  [
            [
                'content' => $this->render('_form_insertRow', ['model' => $vehicleLayoutModel, 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id])
            ],
            '{export}',
        ],
        'export' => [
            'fontAwesome' => false,
            'options' => ['style' => 'margin-top:32px;width:100%;'],
        ],
        'striped' => true,
        'responsive'=>true,
        'condensed'=>true,
        'hover'=>true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Заполнение данных для компоновки "<b>'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'</b>"',
            'footer' => $this->render('_footer', ['vehicleLayoutName_id' => $vehicleLayoutNameModel->id]),
        ],
    ]);
    ?>
</div>