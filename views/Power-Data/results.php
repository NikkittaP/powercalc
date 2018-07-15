<?php

use yii\bootstrap\Tabs;
use yii\bootstrap\Collapse;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

use app\models\ArchitecturesNames;
use app\models\EnergySourceToArchitecture;
use app\models\ResultsConsumers;
use app\models\ResultsEnergySources;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$script = <<< JS
    function resizeChart(chart_id, width, height) {
        var chart = $(chart_id).highcharts();
        $(chart_id).width(width);
        $(chart_id).height(height);
        chart.setSize(width, height, false);
        document.getElementById("sizeLabel").innerHTML = "Размеры графика: "+width+"x"+height;
    }
JS;
$this->registerJs($script, yii\web\View::POS_HEAD);


$this->title = 'Результаты расчёта для компоновки "' . $vehicleLayoutNameModel->vehicle->name . ': ' . $vehicleLayoutNameModel->name . '"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'results', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>
<div class="power-data-results">

    <h3>Выберите архитектуры для отображения результатов по ним:</h3>
    <?php
    echo Html::beginForm(['power-data/results', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id], 'post');
    echo Html::hiddenInput('isPost', '1');
    $items = ArrayHelper::map(ArchitecturesNames::find()->where(['id' => $usingArchitectures, 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id])->all(), 'id', 'name');
    echo Html::checkboxList('selected_architectures', $selectedArchitectures, $items, [
        'item' => function ($index, $label, $name, $checked, $value) use ($basicArchitecture) {
            return Html::checkbox($name, $checked, [
                'value' => $value,
                'disabled' => $value == key($basicArchitecture),
                'label' => $label
            ]);
        },
        'separator' => '<br />',
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Показать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>

<br /><br />
<div class="row">
    <div class="col-sm-12">
        <?php
        $items_root = [];

        // Энергосистемы (расход)
        $items = [];
        foreach ($energySourcesModel as $currentEnergySource) {
            if (in_array($currentEnergySource->id, $usedEnergySourcesInSelectedArchitectures)) {
                $items[] = [
                    'label' => $currentEnergySource->name,
                    'content' => $this->render('_results_chart', [
                        'id' => 'ENERGYSOURCE_Q'.count($items),
                        'chartType' => 'ENERGYSOURCE_Q',
                        'title' => 'Сравнение потребления архитектур для энергосистемы <b>' . $currentEnergySource->name . '</b>',
                        'chart_data' => $chart_data['ENERGYSOURCE_Q'],
                        'flightModeModel' => $flightModeModel,
                        'selectedArchitectures' => $selectedArchitectures,
                        'energySourceID' => $currentEnergySource->id,
                    ]),
                ];
            }
        }
        $items_root[] = [
            'label' => 'Энергосистемы (расход)',
            'content' => Tabs::widget(['items' => $items]),
        ];

        // ΔN_отбора
        $items = [];
        $items[] = [
            'label' => 'ΔN_отбора',
            'content' => $this->render('_results_chart', [
                'id' => 'DELTA_N'.count($items),
                'chartType' => 'DELTA_N',
                'title' => 'ΔN_отбора по архитектурам',
                'chart_data' => $chart_data['DELTA_N'],
                'flightModeModel' => $flightModeModel,
                'selectedArchitectures' => $selectedArchitectures,
            ]),
        ];
        $items_root[] = [
            'label' => 'ΔN_отбора',
            'content' => Tabs::widget(['items' => $items]),
        ];

        // КПД = N_потр_вых_сумм/N_отбора
        $items = [];
        $items[] = [
            'label' => 'КПД',
            'content' => $this->render('_results_chart', [
                'id' => 'EFFICIENCY'.count($items),
                'chartType' => 'EFFICIENCY',
                'title' => 'КПД по архитектурам',
                'chart_data' => $chart_data['EFFICIENCY'],
                'flightModeModel' => $flightModeModel,
                'selectedArchitectures' => $selectedArchitectures,
            ]),
        ];
        $items_root[] = [
            'label' => 'КПД',
            'content' => Tabs::widget(['items' => $items]),
        ];

        // К_одновременности (реализуемый)=Q_насоса/Q_распологаемый
        $items = [];
        foreach ($energySourcesModel as $currentEnergySource) {
            if (in_array($currentEnergySource->id, $usedEnergySourcesInSelectedArchitectures)) {
                $NMax = [];
                if ($currentEnergySource->energySourceType_id == 4)
                {
                    $architectureNamesModels = ArchitecturesNames::find()
                    ->where([
                        'vehicleLayoutName_id' => $vehicleLayoutNameModel->id,
                        'id' => array_values($selectedArchitectures)
                    ])->all();
                    foreach ($architectureNamesModels as $architectureNamesModel) {
                        $NMax[$architectureNamesModel->id] = EnergySourceToArchitecture::find()
                        ->where([
                            'energySource_id' => $currentEnergySource->id,
                            'architectureName_id' => $architectureNamesModel->id
                        ])->one()->NMax;
                    }
                }

                $items[] = [
                    'label' => $currentEnergySource->name,
                    'content' => $this->render('_results_chart', [
                        'id' => 'SIMULTANEITY_INDEX'.count($items),
                        'chartType' => 'SIMULTANEITY_INDEX',
                        'title' => ($currentEnergySource->energySourceType_id == 4) ? 'К_одновременности (реализуемый) для электросистемы '.$currentEnergySource->name : 'К_одновременности (реализуемый) для гидросистемы '.$currentEnergySource->name,
                        'chart_data' => $chart_data['SIMULTANEITY_INDEX'],
                        'flightModeModel' => $flightModeModel,
                        'selectedArchitectures' => $selectedArchitectures,
                        'energySourceID' => $currentEnergySource->id,
                        'isElectric' => ($currentEnergySource->energySourceType_id == 4) ? true : false,
                        'NMax' => $NMax,
                    ]),
                ];
            }
        }
        $items_root[] = [
            'label' => 'К_одновременности (реализуемый)',
            'content' => Tabs::widget(['items' => $items]),
        ];

        echo Tabs::widget(['items' => $items_root]);
?>

        <div id="sizeLabel"></div>

<?php
        // Текстовые данные в виде таблицы
        echo Collapse::widget([
           'items' => [
               [
                   'label' => 'Текстовые данные графиков',
                   'content' =>  $this->render('_results_chart', [
                                    'chartType' => 'TEXT_DATA',
                                    'title' => 'Текстовые данные графиков',
                                    'chart_data' => $chart_data,
                                    'flightModeModel' => $flightModeModel,
                                    'selectedArchitectures' => $selectedArchitectures,
                                ])
               ],
            ]
        ]);
        ?>
    </div>
</div>

<?php
$items = [];
foreach ($alternativeArchitectures as $currentArchitectureID => $currentArchitectureName) {
        $items[] = [
            'label' => $currentArchitectureName,
            'content' => $this->render('_results_per_architecture', [
                'resultsConsumersBasic' => $resultsConsumersBasic,
                'resultsConsumersAlternative' => $resultsConsumersAlternative,
                'currentFlightMode' => $currentFlightMode,
                'currentArchitectureID' => $currentArchitectureID,
                'basicArchitecture' => $basicArchitecture,
                'currentArchitectureName' => $currentArchitectureName,
                'resultsEnergySourcesBasic' => $resultsEnergySourcesBasic,
                'resultsEnergySourcesAlternative' => $resultsEnergySourcesAlternative,
                'flightModeModel' => $flightModeModel,
            ]),
        ];
}

echo Tabs::widget([
    'items' => $items,
]);
?>


<br /><br />

<div class="row">
    <div class="col-sm-6">
        <?= $this->render('_results_by_aircraft_parts', [
            'flightModeModel' => $flightModeModel,
            'aircraftPartsModel' => $aircraftPartsModel,
            'N_out_by_parts' => $N_out_by_parts,
        ]);
        ?>
    </div>
</div>

<br /><br />

</div>