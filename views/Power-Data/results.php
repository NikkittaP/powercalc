<?php

use yii\bootstrap\Tabs;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

use app\models\ArchitecturesNames;
use app\models\ResultsConsumers;
use app\models\ResultsEnergySources;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

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
            if (in_array($currentEnergySource->id, $usedEnergySourcesInSelectedArchitectures) && $currentEnergySource->energySourceType_id != 4) {
                $items[] = [
                    'label' => $currentEnergySource->name,
                    'content' => $this->render('_results_chart', [
                        'chartType' => 'SIMULTANEITY_INDEX',
                        'title' => 'К_одновременности (реализуемый) по гидросистемам',
                        'chart_data' => $chart_data['SIMULTANEITY_INDEX'],
                        'flightModeModel' => $flightModeModel,
                        'selectedArchitectures' => $selectedArchitectures,
                        'energySourceID' => $currentEnergySource->id,
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
    </div>
</div>

<?php
foreach ($alternativeArchitectures as $currentArchitectureID => $currentArchitectureName) {
    ?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Сравнение базовой архитектуры "<b><?= current($basicArchitecture); ?></b>" с альтернативной "<b><?= $currentArchitectureName; ?></b>"
            </h3>
        </div>
        <div class="panel-body">
            <?php
            $items = [];
            foreach ($flightModeModel as $currentFlightMode) {
                $items[] = [
                    'label' => $currentFlightMode->name,
                    'content' => $this->render('_results_per_flightmode', [
                        'resultsConsumersBasic' => $resultsConsumersBasic,
                        'resultsConsumersAlternative' => $resultsConsumersAlternative,
                        'currentFlightMode' => $currentFlightMode,
                        'currentArchitectureID' => $currentArchitectureID,
                        'basicArchitecture' => $basicArchitecture,
                        'currentArchitectureName' => $currentArchitectureName,
                        'resultsEnergySourcesBasic' => $resultsEnergySourcesBasic,
                        'resultsEnergySourcesAlternative' => $resultsEnergySourcesAlternative,
                    ]),
                ];
            }

            echo Tabs::widget([
                'items' => $items,
            ]);
            ?>
        </div>
    </div>

<?php

}
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