<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

use \app\models\ArchitecturesNames;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Результаты расчёта для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="power-data-results">

    <h3>Выберите архитектуры для отображения результатов по ним:</h3>
    <?php
    echo Html::beginForm(['power-data/results', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id],'post');
    $items = ArrayHelper::map($architectureNames->all(), 'id', 'name');
    echo Html::checkboxList('selected_architectures', $selectedArchitectures, $items,  [
        'item' => function ($index, $label, $name, $checked, $value) use($basicArchitectureID) {
            return Html::checkbox($name, $checked, [
                'value' => $value,
                'disabled' => $value == $basicArchitectureID,
                'label' => $label
            ]);
        },
        'separator'=>'<br />',
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Показать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>

    <?php
    
    /*
    $dataProviderResultsConsumers = new ActiveDataProvider([
        'query' => $resultsConsumers,
        'pagination' => false,
    ]);
    $gridColumnsResultsConsumers = [
        [
            'attribute' => 'architectureName_id',
            'value' => 'architectureName.name',
        ],
        [
            'attribute' => 'flightMode_id',
            'value' => 'flightMode.name',
        ],
        [
            'attribute' => 'consumer_id',
            'value' => 'consumer.name',
        ],
        'consumption',
        'P_in',
        'N_in_hydro',
        'N_out',
        'N_in_electric',
    ];

    echo GridView::widget([
        'dataProvider'=> $dataProviderResultsConsumers,
        'columns' => $gridColumnsResultsConsumers,
        'toolbar' =>  [
            '{export}',
        ],
        'export' => [
            'fontAwesome' => false,
        ],
        'striped' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Результаты расчёта для компоновки "<b>'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'</b>"',
        ],
    ]);
    */
    ?>
</div>