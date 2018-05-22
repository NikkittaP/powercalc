<?php

use miloschuman\highcharts\Highcharts;
use yii\web\JsExpression;
use yii\helpers\VarDumper;
?>

<?php

$yAxisTitle = 'yAxisTitle';

if ($chartType == 'TEXT_DATA')
{
    $basicArchitectureID = -1;
    foreach ($selectedArchitectures as $currentArchitectureID) {
        if ($chart_data[$currentArchitectureID]['isBasic'] == true)
            $basicArchitectureID = $currentArchitectureID;
    }
    
    foreach ($selectedArchitectures as $currentArchitectureID) {
        foreach ($flightModeModel as $currentFlightMode) {
            if ($currentArchitectureID != $basicArchitectureID)
                $textData['DELTA_N'][$currentFlightMode->id][$currentArchitectureID] = round(($chart_data['DELTA_N'][$currentArchitectureID][$currentFlightMode->id]['N_takeoff'] - $chart_data['DELTA_N'][$basicArchitectureID][$currentFlightMode->id]['N_takeoff']), 1);
            $textData['EFFICIENCY'][$currentFlightMode->id][$currentArchitectureID] = round(($chart_data['EFFICIENCY'][$currentArchitectureID][$currentFlightMode->id]['N_consumers_out'] / $chart_data['EFFICIENCY'][$currentArchitectureID][$currentFlightMode->id]['N_takeoff']) * 100, 1);
        }
    }

    ?>
    <table class="table table-bordered table-condensed table-hover medium kv-table">
        <tbody>
        <tr class="active">
            <th colspan="2"></th>
            <th class="text-center"><h5><b>ΔN_отбора</b></h5></th>
            <th class="text-center"><h5><b>КПД</b></h5></th>
        </tr>
        <?php
        foreach ($flightModeModel as $currentFlightMode) {
            $isNewFM = true;
            foreach ($selectedArchitectures as $currentArchitectureID) {
        ?>
                <tr>
                    <?php
                    if ($isNewFM) {
                    ?>
                        <td rowspan="<?=count($selectedArchitectures);?>" width="350"><b><?=$currentFlightMode->name;?></b></td>
                    <?php
                    }
                    ?>
                    <td><b><?=$chart_data['DELTA_N'][$currentArchitectureID]['architectureName'];?></b></td>
                    <td><?=$textData['DELTA_N'][$currentFlightMode->id][$currentArchitectureID];?></td>
                    <td><?=$textData['EFFICIENCY'][$currentFlightMode->id][$currentArchitectureID];?></td>
                </tr>
        <?php
            $isNewFM = false;
            }
        }
        ?>
        </tbody>
    </table>
    <?php
    return;
}

if ($chartType == 'ENERGYSOURCE_Q') {
    $yAxisTitle = 'Потребление';

    $seriesColumnData = [];
    $seriesLineData = [];
    $series = [];

    foreach ($flightModeModel as $currentFlightMode) {
        $seriesLineData[] = round($chart_data[$currentFlightMode->id][$energySourceID]['Qdisposable'], 1);
    }

    foreach ($selectedArchitectures as $currentArchitectureID) {
        foreach ($flightModeModel as $currentFlightMode) {
            $seriesColumnData[$currentArchitectureID][] = round($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qpump'], 1);
        }
        $series[] = [
            'type' => 'column',
            'name' => $chart_data[$currentArchitectureID]['architectureName'],
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
    
} else if ($chartType == 'DELTA_N') {
    $yAxisTitle = 'ΔN_отбора';

    $seriesColumnData = [];
    $series = [];

    $basicArchitectureID = -1;
    foreach ($selectedArchitectures as $currentArchitectureID) {
        if ($chart_data[$currentArchitectureID]['isBasic'] == true)
            $basicArchitectureID = $currentArchitectureID;
    }
    
    foreach ($selectedArchitectures as $currentArchitectureID) {
        if ($currentArchitectureID != $basicArchitectureID)
        {
            foreach ($flightModeModel as $currentFlightMode) {
                $seriesColumnData[$currentArchitectureID][] = round(($chart_data[$currentArchitectureID][$currentFlightMode->id]['N_takeoff'] - $chart_data[$basicArchitectureID][$currentFlightMode->id]['N_takeoff']), 1);
            }
            $series[] = [
                'type' => 'column',
                'name' => $chart_data[$currentArchitectureID]['architectureName'],
                'data' => $seriesColumnData[$currentArchitectureID],
            ];
        }
    }
} else if ($chartType == 'EFFICIENCY') {
    $yAxisTitle = 'КПД, %';
    
    $seriesColumnData = [];
    $series = [];
    
    foreach ($selectedArchitectures as $currentArchitectureID) {
        foreach ($flightModeModel as $currentFlightMode) {
            $seriesColumnData[$currentArchitectureID][] = round(($chart_data[$currentArchitectureID][$currentFlightMode->id]['N_consumers_out'] / $chart_data[$currentArchitectureID][$currentFlightMode->id]['N_takeoff']) * 100, 1);
        }
        $series[] = [
            'type' => 'column',
            'name' => $chart_data[$currentArchitectureID]['architectureName'],
            'data' => $seriesColumnData[$currentArchitectureID],
        ];
    }
} else if ($chartType == 'SIMULTANEITY_INDEX') {
    $yAxisTitle = 'К_одновременности';

    $seriesColumnData = [];
    $series = [];

    foreach ($selectedArchitectures as $currentArchitectureID) {
        foreach ($flightModeModel as $currentFlightMode) {
            if ($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qdisposable'] == 0)
                $seriesColumnData[$currentArchitectureID][] = 0;
            else
                $seriesColumnData[$currentArchitectureID][] = round(($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qpump'] / $chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qdisposable']), 1);
        }
        $series[] = [
            'type' => 'column',
            'name' => $chart_data[$currentArchitectureID]['architectureName'],
            'data' => $seriesColumnData[$currentArchitectureID],
        ];
    }
}



$flightModes = [];
foreach ($flightModeModel as $currentFlightMode) {
    $flightModes[] = $currentFlightMode->name;
}

echo Highcharts::widget([
    'scripts' => [
        'modules/exporting',
        'themes/avocado',
    ],
    'options' => [
        'credits' => ['enabled' => false],
        'chart' => [
            'height' => 900,
            //'width' => 1000,
            'style' => [
            //'fontFamily' => 'Arial',
            ],
        ],
        'title' => [ 'text' => $title ],
        'xAxis' => [
            'title' => [ 'text' => 'Режимы полёта' ],
            'categories' => $flightModes,
        ],
        'yAxis' => [
            'title' => [ 'text' => $yAxisTitle ],
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