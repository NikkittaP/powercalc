<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
?>

<?php

$flightModes = [];
$seriesColumnData = [];
$seriesLineData = [];
$series = [];

foreach ($flightModeModel as $currentFlightMode) {
    $flightModes[] = $currentFlightMode->name;

    $seriesLineData[] = $chart_data['basic'][$currentFlightMode->id]['Qdisposable'];
}

foreach ($selectedArchitectures as $currentArchitectureID) {
    foreach ($flightModeModel as $currentFlightMode) {
        $seriesColumnData[$currentArchitectureID][] = $chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qpump'];
    }
    $series[] = [
        'type' => 'column',
        'name' => $chart_data[$currentArchitectureID][$currentFlightMode->id]['architectureName'],
        'data' => $seriesColumnData[$currentArchitectureID],
    ];
}

$series[] = [
    'type' => 'spline',
    'name' => 'Располагаемый расход',
    'data' => $seriesLineData,
    'marker' => [
        'lineWidth' => 2,
        'lineColor' => new JsExpression('Highcharts.getOptions().colors[3]'),
        'fillColor' => 'white',
    ],
];

?>

<?= Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/avocado',
    ],
    'options' => [
        'credits' => ['enabled' => false],
        'chart'=>[
            //'height'=>  500,
            //'width' => 1000,
            'style' => [
                //'fontFamily' => 'Arial',
            ],
        ],
        'title' => [
            'text' => $title,
        ],
        'xAxis' => [
            'title' => [
                'text' => 'Режимы полёта',
            ],
            'categories' => $flightModes,
        ],
        'yAxis' => [
            'title' => [
                'text' => 'Потребление',
            ],
        ],
        'plotOptions' => [
            'column' => [
                'borderRadius' => 5,
            ],
        ],
        'series' => $series,
    ]
    ]);
?>