<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заполнение данных для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="power-data-index">
    <?php
    $consumers = ArrayHelper::map(app\models\Consumers::find()->orderBy('name')->asArray()->all(), 'id', 'name');

    $gridColumns = [
        [
            'attribute' => 'id',
            'width' => '70px',
            'hAlign' => 'center',
            'vAlign' => 'center',
        ],
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
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'consumer_id',
            'content'=>function ($model, $key, $index, $column) {
                return app\models\Consumers::findOne($model->consumer_id)->name;
            },
            'readonly' => false,
            'editableOptions' => [
                'asPopover' => false,
                'header' => 'Потребитель',
                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                'data'=>$consumers,
                'displayValueConfig'=>$consumers,
                'options' => [
                    'class'=>'form-control input-sm',
                    'prompt'=>'Выберите потребителя...'
                ],
            ],
            //'width' => '400px',
        ],
    ];

    /* Столбцы архитектур */
    $architecturesNames = app\models\ArchitecturesNames::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutNameModel->id])->orderBy('name')->all();
    $energySources = ArrayHelper::map(app\models\EnergySources::find()->orderBy('name')->asArray()->all(), 'id', 'name');
    $i=0;
    foreach ($architecturesNames as $architecturesName)
    {
        $border = [];
        if ($i==0)
            $border = ['style' => 'border-left:5px solid green;'];

        $gridColumns[] = [
            'class' => 'kartik\grid\EditableColumn',
            'attribute'=>'architectureToVehicleLayouts_'.$architecturesName->id,
            'value'=>function ($model, $key, $index, $column) use($architecturesName) {
                $m = app\models\ArchitectureToVehicleLayout::find()->where(['vehicleLayout_id'=>$model->id, 'architectureName_id'=>$architecturesName->id])->one();
                if ($m==null)
                    return '';
                return app\models\EnergySources::findOne($m->energySource_id)->name;
            },
            'readonly' => false,
            'editableOptions' => [
                'name' => 'architectureToVehicleLayouts_'.$architecturesName->id,
                'value'=>function ($model, $key, $index, $column) use($architecturesName) {
                    $m = app\models\ArchitectureToVehicleLayout::find()->where(['vehicleLayout_id'=>$model->id, 'architectureName_id'=>$architecturesName->id])->one();
                    if ($m==null)
                        return '';
                    return $m->energySource_id;
                },
                'asPopover' => false,
                'header' => 'Источник энергии',
                'inputType' => \kartik\editable\Editable::INPUT_SELECT2,
                'displayValueConfig'=>$energySources,
                'options' => [
                    'data'=>$energySources,
                    'class'=>'form-control input-sm',
                    'size' => 'sm',
                    'options' => [
                        'placeholder' => 'Источник энергии',
                    ],
                ],
            ],
            'contentOptions' => $border,
            'headerOptions' => $border,
            'filterOptions' => $border,
            'width' => '10%',
        ];

        $i++;
    }

    /* Столбцы режимов полёта */
    $flightModes = app\models\FlightModes::find()->orderBy('name')->all();
    $i=0;
    foreach ($flightModes as $flightMode)
    {
        $border = [];
        if ($i==0)
            $border = ['style' => 'border-left:5px solid green;'];

        $gridColumns[] = [
            'class' => 'kartik\grid\EditableColumn',
            'attribute'=>'flightModesToVehicleLayout_'.$flightMode->id,
            'value'=>function ($model, $key, $index, $column) use($flightMode) {
                $m = app\models\FlightModesToVehicleLayout::find()->where(['vehicleLayout_id'=>$model->id, 'flightMode_id'=>$flightMode->id])->one();
                if ($m==null)
                    return '';
                return $m->usageFactor;
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
            'contentOptions' => $border,
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
        //'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'toolbar' =>  [
            [
                'content' => $this->render('_form_insertRow', ['model' => $vehicleLayoutModel, 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id])
            ],
            '{export}',
        ],
        'export' => [
            'fontAwesome' => false,
            'options' => ['style' => 'margin-top:32px;'],
        ],
        'striped' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Заполнение данных для компоновки "<b>'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'</b>"',
            'footer' => $this->render('_footer', ['vehicleLayoutName_id' => $vehicleLayoutNameModel->id]),
        ],
    ]);
    ?>
</div>