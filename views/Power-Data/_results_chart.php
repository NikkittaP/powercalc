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

    $seriesLineData[] = round($chart_data[$currentFlightMode->id][$energySourceID]['Qdisposable'], 1);
}

foreach ($selectedArchitectures as $currentArchitectureID) {
    foreach ($flightModeModel as $currentFlightMode) {
        $seriesColumnData[$currentArchitectureID][] = round($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qpump'], 1);
    }
    $series[] = [
        'type' => 'column',
        'name' => $chart_data[$currentArchitectureID][$currentFlightMode->id]['architectureName'],
        'data' => $seriesColumnData[$currentArchitectureID],
    ];
}

$series[] = [
    'type' => 'spline',
    //'type' => 'areaspline',
    'fillOpacity' => 0.1,
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
            'height'=>  900,
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