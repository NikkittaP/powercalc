<?php

use miloschuman\highcharts\Highcharts;
use yii\jui\Resizable;
use yii\web\JsExpression;
?>

<?php

$yAxisTitle = 'yAxisTitle';

if ($chartType == 'TEXT_DATA') {
    $basicArchitectureID = -1;
    foreach ($selectedArchitectures as $currentArchitectureID) {
        if ($chart_data[$currentArchitectureID]['isBasic'] == true) {
            $basicArchitectureID = $currentArchitectureID;
        }

    }

    foreach ($selectedArchitectures as $currentArchitectureID) {
        foreach ($flightModeModel as $currentFlightMode) {
            if ($currentArchitectureID != $basicArchitectureID) {
                $textData['DELTA_N'][$currentFlightMode->id][$currentArchitectureID] = round(($chart_data['DELTA_N'][$currentArchitectureID][$currentFlightMode->id]['N_takeoff'] - $chart_data['DELTA_N'][$basicArchitectureID][$currentFlightMode->id]['N_takeoff']), 1);
            }

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

    foreach ($selectedArchitectures as $currentArchitectureID) {

        $tmp = [];
        $allZeros = true;
        foreach ($flightModeModel as $currentFlightMode) {
            $value = round($chart_data[$currentFlightMode->id][$energySourceID][$currentArchitectureID]['Qdisposable'], 1);

            if ($value != 0) {
                $allZeros = false;
            }

            $tmp[] = $value;
        }

        if (!$allZeros) {
            $seriesLineData[$currentArchitectureID] = $tmp;
        }

    }

    foreach ($selectedArchitectures as $currentArchitectureID) {
        $tmp = [];
        $allZeros = true;
        foreach ($flightModeModel as $currentFlightMode) {
            $value = round($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qpump'], 1);

            if ($value != 0) {
                $allZeros = false;
            }

            $tmp[] = $value;
        }

        if (!$allZeros) {
            $seriesColumnData[$currentArchitectureID] = $tmp;
        }

        if (isset($seriesColumnData[$currentArchitectureID])) {
            $series[] = [
                'type' => 'column',
                'color' => $chart_data[$currentArchitectureID]['architectureChartColor'],
                'name' => $chart_data[$currentArchitectureID]['architectureName'],
                'data' => $seriesColumnData[$currentArchitectureID],
            ];
        }
    }

    foreach ($selectedArchitectures as $currentArchitectureID) {
        if (isset($seriesLineData[$currentArchitectureID])) {
            $series[] = [
                'type' => 'spline',
                //'type' => 'areaspline',
                'fillOpacity' => 0.1,
                'name' => 'Располагаемый расход ' . $chart_data[$currentArchitectureID]['architectureName'],
                'data' => $seriesLineData[$currentArchitectureID],
                'color' => $chart_data[$currentArchitectureID]['architectureChartColor'],
                'marker' => [
                    'lineWidth' => 2,
                    'lineColor' => $chart_data[$currentArchitectureID]['architectureChartColor'],
                    'fillColor' => 'white',
                ],
            ];
        }
    }

} else if ($chartType == 'DELTA_N') {
    $yAxisTitle = 'ΔN_отбора';

    $seriesColumnData = [];
    $series = [];

    $basicArchitectureID = -1;
    foreach ($selectedArchitectures as $currentArchitectureID) {
        if ($chart_data[$currentArchitectureID]['isBasic'] == true) {
            $basicArchitectureID = $currentArchitectureID;
        }
    }

    foreach ($selectedArchitectures as $currentArchitectureID) {
        if ($currentArchitectureID != $basicArchitectureID) {
            $tmp = [];
            $allZeros = true;
            foreach ($flightModeModel as $currentFlightMode) {
                $value = round(($chart_data[$currentArchitectureID][$currentFlightMode->id]['N_takeoff'] - $chart_data[$basicArchitectureID][$currentFlightMode->id]['N_takeoff']), 1);

                if ($value != 0) {
                    $allZeros = false;
                }

                $tmp[] = $value;
            }

            if (!$allZeros) {
                $seriesColumnData[$currentArchitectureID] = $tmp;
            }

            if (isset($seriesColumnData[$currentArchitectureID])) {
                $series[] = [
                    'type' => 'column',
                    'color' => $chart_data[$currentArchitectureID]['architectureChartColor'],
                    'name' => $chart_data[$currentArchitectureID]['architectureName'],
                    'data' => $seriesColumnData[$currentArchitectureID],
                ];
            }
        }
    }
} else if ($chartType == 'EFFICIENCY') {
    $yAxisTitle = 'КПД, %';

    $seriesColumnData = [];
    $series = [];

    foreach ($selectedArchitectures as $currentArchitectureID) {
        $tmp = [];
        $allZeros = true;
        foreach ($flightModeModel as $currentFlightMode) {
            $value = round(($chart_data[$currentArchitectureID][$currentFlightMode->id]['N_consumers_out'] / $chart_data[$currentArchitectureID][$currentFlightMode->id]['N_takeoff']) * 100, 1);

            if ($value != 0) {
                $allZeros = false;
            }

            $tmp[] = $value;
        }

        if (!$allZeros) {
            $seriesColumnData[$currentArchitectureID] = $tmp;
        }

        if (isset($seriesColumnData[$currentArchitectureID])) {
            $series[] = [
                'type' => 'column',
                'color' => $chart_data[$currentArchitectureID]['architectureChartColor'],
                'name' => $chart_data[$currentArchitectureID]['architectureName'],
                'data' => $seriesColumnData[$currentArchitectureID],
            ];
        }
    }
} else if ($chartType == 'SIMULTANEITY_INDEX') {
    $yAxisTitle = 'К_одновременности';

    $seriesColumnData = [];
    $series = [];

    foreach ($selectedArchitectures as $currentArchitectureID) {
        $tmp = [];
        $allZeros = true;
        foreach ($flightModeModel as $currentFlightMode) {
            if ($isElectric) {
                if ($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['N_generator_out'] == 0) {
                    $value = 0;
                } else {
                    $value = round(($NMax[$currentArchitectureID] / $chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['N_generator_out']), 1);
                    if ($value > 1) {
                        $value = 1;
                    }
                }
            } else {
                if ($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['QpumpUF1'] == 0) {
                    $value = 0;
                } else {
                    $value = round(($chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['Qdisposable'] / $chart_data[$currentArchitectureID][$currentFlightMode->id][$energySourceID]['QpumpUF1']), 1);
                    if ($value > 1) {
                        $value = 1;
                    }
                }
            }

            if ($value != 0) {
                $allZeros = false;
            }

            $tmp[] = $value;
        }

        if (!$allZeros) {
            $seriesColumnData[$currentArchitectureID] = $tmp;
        }

        if (isset($seriesColumnData[$currentArchitectureID])) {
            $series[] = [
                'type' => 'column',
                'color' => $chart_data[$currentArchitectureID]['architectureChartColor'],
                'name' => $chart_data[$currentArchitectureID]['architectureName'],
                'data' => $seriesColumnData[$currentArchitectureID],
            ];
        }
    }
}

$flightModes = [];
foreach ($flightModeModel as $currentFlightMode) {
    $flightModes[] = $currentFlightMode->name;
}

$chartHeight = (app\models\Constants::getValue('chartHeight') == null) ? 1500 : app\models\Constants::getValue('chartHeight');
$chartWidth = (app\models\Constants::getValue('chartWidth') == null) ? 900 : app\models\Constants::getValue('chartWidth');

Resizable::begin([
    'clientEvents' => [
        'resize' => 'function( event, ui ) {
            resizeChart("#resultsChart_' . $id . '", this.offsetWidth, this.offsetHeight);
          }',
    ],
    'clientOptions' => [
        'grid' => [20, 10],
        'minHeight' => 100,
        'minWidth' => 200,
    ],
    'options' => [
        'style' => "width:" . $chartWidth . "px;height:" . $chartHeight . "px",
    ],
]);

echo Highcharts::widget([
    'htmlOptions' => [
        'id' => 'resultsChart_' . $id,
    ],
    'scripts' => [
        'modules/exporting',
        'modules/export-data',
        'themes/avocado',
    ],
    'options' => [
        'credits' => ['enabled' => false],
        'chart' => [
            'height' => $chartHeight,
            'width' => $chartWidth,
            'style' => [
            //'fontFamily' => 'Arial',
            ],
        ],
        'title' => ['text' => $title],
        'xAxis' => [
            'title' => ['text' => 'Режимы полёта'],
            'categories' => $flightModes,
        ],
        'yAxis' => [
            'title' => ['text' => $yAxisTitle],
        ],
        'plotOptions' => [
            'column' => [
                'borderRadius' => 5,
            ],
        ],
        'series' => $series,
    ],
]);

Resizable::end();
?>