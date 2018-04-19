<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Результаты расчёта для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="power-data-results">
    <?php
    
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
    ?>
</div>