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

$this->title = 'Результаты расчёта для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="power-data-results">

    <h3>Выберите архитектуры для отображения результатов по ним:</h3>
    <?php
    echo Html::beginForm(['power-data/results', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id],'post');
    $items = ArrayHelper::map(ArchitecturesNames::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutNameModel->id])->all(), 'id', 'name');
    echo Html::checkboxList('selected_architectures', $selectedArchitectures, $items,  [
        'item' => function ($index, $label, $name, $checked, $value) use($basicArchitecture) {
            return Html::checkbox($name, $checked, [
                'value' => $value,
                'disabled' => $value == key($basicArchitecture),
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

<br /><br />
<div class="row">
    <div class="col-sm-12">
        <?php
        $items = [];
        foreach ($energySourcesModel as $currentEnergySource) {
            if (in_array($currentEnergySource->id, $usedEnergySourcesInSelectedArchitectures))
            {
                $items[] = [
                    'label'     =>  $currentEnergySource->name,
                    'content'   =>  $this->render('_results_chart', [
                        'title' => 'Сравнение потребления архитектур для энергосистемы <b>'.$currentEnergySource->name.'</b>',
                        'chart_data' => $chart_data,
                        'flightModeModel' => $flightModeModel,
                        'selectedArchitectures' => $selectedArchitectures,
                        'energySourceID' => $currentEnergySource->id,
                        ]),
                ];
            }
        }

        echo Tabs::widget([
                'items' => $items,
            ]);
        ?>
    </div>
</div>
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

<?php
foreach ($alternativeArchitectures as $currentArchitectureID => $currentArchitectureName) {
?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Сравнение базовой архитектуры "<b><?= current($basicArchitecture);?></b>" с альтернативной "<b><?= $currentArchitectureName;?></b>"
            </h3>
        </div>
        <div class="panel-body">
            <?php
            foreach ($flightModeModel as $currentFlightMode) {
            ?>
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Режим полёта "<b><?= $currentFlightMode->name;?></b>"
                    </h3>
                </div>
                <div class="panel-body">
                    <?= $this->render('_results_consumers', [
                            'resultsConsumersBasic' => $resultsConsumersBasic,
                            'resultsConsumersAlternative' => $resultsConsumersAlternative,
                            'currentFlightMode' => $currentFlightMode,
                            'currentArchitectureID' => $currentArchitectureID,
                            ]);
                    ?>

                    <?= $this->render('_results_energySources', [
                            'title' => 'Базовая архитектура "<b>'.current($basicArchitecture).'</b>"',
                            'isBasic' => true,
                            'resultsEnergySources' => $resultsEnergySourcesBasic,
                            'currentFlightMode' => $currentFlightMode,
                            'currentArchitectureID' => $currentArchitectureID,
                            ]);
                    ?>

                    <?= $this->render('_results_energySources', [
                            'title' => 'Альтернативная архитектура "<b>'.$currentArchitectureName.'</b>"',
                            'isBasic' => false,
                            'resultsEnergySources' => $resultsEnergySourcesAlternative,
                            'currentFlightMode' => $currentFlightMode,
                            'currentArchitectureID' => $currentArchitectureID,
                            ]);
                    ?>
                </div>
            </div>
            <?php
            }
            ?>
        </div>
    </div>

<?php
}
?>
</div>