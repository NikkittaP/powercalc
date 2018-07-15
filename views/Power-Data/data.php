<?php

use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Данные для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'data', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>

<div class="power-data-data">

    <h3>Выберите группу потребителей для отображения данных по ним:</h3>
    <?php
    echo Html::beginForm(['power-data/data', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id], 'post', ['class'=>'form-group']);
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
    if ($selectedConsumerGroup == 0)
        $consumers = ArrayHelper::map(app\models\Consumers::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    else
        $consumers = ArrayHelper::map(app\models\Consumers::find()->where(['consumerGroup_id' => $selectedConsumerGroup])->orderBy('name')->asArray()->all(), 'id', 'name');

    $gridColumns = [
        [
            'attribute' => 'id',
            'width' => '70px',
            'hAlign' => 'center',
            'vAlign' => 'center',
        ],
        [
            'attribute' => 'consumer_id',
            'value' => function($model, $key, $index, $column) use($consumers) {
                return $consumers[$model->consumer_id];
            },
            'contentOptions' => ['style' => 'width:200px;'],
            'noWrap' => true
        ]
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

        $style =['style' => $border.$background];

        $gridColumns[] = [
            'attribute'=>'architectureToVehicleLayouts_'.$architecturesName->id,
            'content'=>function ($model, $key, $index, $column) use($architecturesName, $architectureToVehicleLayouts, $energySources) {
                if (!isset($architectureToVehicleLayouts[$model->id][$architecturesName->id]))
                    return '&ndash;';
                return $energySources[$architectureToVehicleLayouts[$model->id][$architecturesName->id]];
            },
            'contentOptions' => $style,
            'headerOptions' => $style,
            'filterOptions' => $style,
            'width' => '10%',
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
            'attribute'=>'flightModesToVehicleLayout_'.$flightMode->id,
            'content'=>function ($model, $key, $index, $column) use($flightMode, $flightModesToVehicleLayouts) {
                if (!isset($flightModesToVehicleLayouts[$model->id][$flightMode->id]))
                    return '';
                return '<b>'.round($flightModesToVehicleLayouts[$model->id][$flightMode->id], 2).'</b>';
            },
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

                    return ['style' => $style, 'class' => $class];
                }
            },
            'headerOptions' => $border,
            'filterOptions' => $border,
            'width' => '10%',
            'hAlign' => 'center',
            'vAlign' => 'center',
        ];

        $i++;
    }

    echo GridView::widget([
        'dataProvider'=> $dataProvider,
        'columns' => $gridColumns,
        //'floatHeader'=>true,
        'toolbar' =>  [
            '{export}',
        ],
        'export' => [
            'fontAwesome' => false,
            'options' => ['style' => 'margin-top:32px;'],
        ],
        'striped' => true,
        'responsive'=>true,
        'condensed'=>true,
        'hover'=>true,
        'options' => ['style' => 'width:100%;'],
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Данные для компоновки "<b>'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'</b>"',
            'footer' => $this->render('_footer', ['vehicleLayoutName_id' => $vehicleLayoutNameModel->id]),
        ],
    ]);
    ?>
</div>