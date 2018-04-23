<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

use \app\models\ArchitecturesNames;
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
        
                                <div class="row">
                                    <div class="col-sm-12">
                                        <table class="table table-bordered table-condensed table-hover medium kv-table">
                                            <tbody>
                                            <tr class="success">
                                                <?php
                                                $resultsConsumerModel = new ResultsConsumers();
                                                ?>
                                                <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('consumer_id');?></th>
                                                <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('consumption');?></th>
                                                <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('P_in');?></th>
                                                <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('N_in_hydro');?></th>
                                                <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('N_out');?></th>
                                                <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('N_in_electric');?></th>
                                            </tr>
                                            <?php
                                            $total['N_in_electric'] = 0;
                                            foreach ($resultsConsumersBasic as $currentResultsConsumersBasic) {
                                                if ($currentResultsConsumersBasic->flightMode_id == $currentFlightMode->id)
                                                {
                                                    $currentResultsConsumersAlternative = null;
                                                    foreach ($resultsConsumersAlternative as $current) {
                                                        if ($current->architectureName_id == $currentArchitectureID
                                                            && $current->consumer_id == $currentResultsConsumersBasic->consumer_id
                                                            && $current->flightMode_id == $currentFlightMode->id)
                                                            $currentResultsConsumersAlternative = $current;
                                                    }

                                                    $total['N_in_electric']+=$currentResultsConsumersAlternative->N_in_electric;
                                            ?>
                                                    <tr>
                                                        <td><?= $currentResultsConsumersBasic->consumer->name;?></td>
                                                        <td><?= $currentResultsConsumersBasic->consumption;?></td>
                                                        <td><?= $currentResultsConsumersBasic->P_in;?></td>
                                                        <td><?= $currentResultsConsumersBasic->N_in_hydro;?></td>
                                                        <td><?= $currentResultsConsumersBasic->N_out;?></td>
                                                        <td><?= ($currentResultsConsumersAlternative->N_in_electric == null) ? '&ndash;' : $currentResultsConsumersAlternative->N_in_electric;?></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                                <tr style="border-top: 3px solid gray;">
                                                    <td><b>ВСЕГО</b></td>
                                                    <td>&ndash;</td>
                                                    <td>&ndash;</td>
                                                    <td>&ndash;</td>
                                                    <td>&ndash;</td>
                                                    <td><?= $total['N_in_electric']?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-warning">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    Базовая архитектура "<b><?= current($basicArchitecture);?></b>"
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-bordered table-condensed table-hover medium kv-table">
                                                    <tbody>
                                                    <tr class="warning">
                                                        <?php
                                                        $resultsEnergySourcesModel = new ResultsEnergySources();
                                                        ?>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('energySource_id');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('Qpump');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('Qdisposable');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('P_pump_out');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('Q_curr_to_Q_max');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_pump_out');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_pump_in');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_consumers_in_hydro');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_consumers_out');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_electric_total');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_takeoff');?></th>
                                                    </tr>
                                                    <?php
                                                    $total['Qpump'] = 0;
                                                    $total['Qdisposable'] = 0;
                                                    $total['P_pump_out'] = 0;
                                                    $total['Q_curr_to_Q_max'] = 0;
                                                    $total['N_pump_out'] = 0;
                                                    $total['N_pump_in'] = 0;
                                                    $total['N_consumers_in_hydro'] = 0;
                                                    $total['N_consumers_out'] = 0;
                                                    $total['N_electric_total'] = 0;
                                                    $total['N_takeoff'] = 0;
                                                    foreach ($resultsEnergySourcesBasic as $currentResultsEnergySourcesBasic) {
                                                        if ($currentResultsEnergySourcesBasic->flightMode_id == $currentFlightMode->id)
                                                        {
                                                            $total['Qpump']+=$currentResultsEnergySourcesBasic->Qpump;
                                                            $total['Qdisposable']+=$currentResultsEnergySourcesBasic->Qdisposable;
                                                            $total['P_pump_out']+=$currentResultsEnergySourcesBasic->P_pump_out;
                                                            $total['Q_curr_to_Q_max']+=$currentResultsEnergySourcesBasic->Q_curr_to_Q_max;
                                                            $total['N_pump_out']+=$currentResultsEnergySourcesBasic->N_pump_out;
                                                            $total['N_pump_in']+=$currentResultsEnergySourcesBasic->N_pump_in;
                                                            $total['N_consumers_in_hydro']+=$currentResultsEnergySourcesBasic->N_consumers_in_hydro;
                                                            $total['N_consumers_out']+=$currentResultsEnergySourcesBasic->N_consumers_out;
                                                            $total['N_electric_total']+=$currentResultsEnergySourcesBasic->N_electric_total;
                                                            $total['N_takeoff']+=$currentResultsEnergySourcesBasic->N_takeoff;
                                                    ?>
                                                            <tr>
                                                                <td><?= $currentResultsEnergySourcesBasic->energySource->name;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->Qpump === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->Qpump;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->Qdisposable === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->Qdisposable;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->P_pump_out === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->P_pump_out;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->Q_curr_to_Q_max === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->Q_curr_to_Q_max;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->N_pump_out === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->N_pump_out;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->N_pump_in === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->N_pump_in;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->N_consumers_in_hydro === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->N_consumers_in_hydro;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->N_consumers_out === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->N_consumers_out;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->N_electric_total === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->N_electric_total;?></td>
                                                                <td><?= ($currentResultsEnergySourcesBasic->N_takeoff === null) ? '&ndash;' : $currentResultsEnergySourcesBasic->N_takeoff;?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <tr style="border-top: 3px solid gray;">
                                                        <td><b>ВСЕГО</b></td>
                                                        <td><?= $total['Qpump']?></td>
                                                        <td><?= $total['Qdisposable']?></td>
                                                        <td><?= $total['P_pump_out']?></td>
                                                        <td><?= $total['Q_curr_to_Q_max']?></td>
                                                        <td><?= $total['N_pump_out']?></td>
                                                        <td><?= $total['N_pump_in']?></td>
                                                        <td><?= $total['N_consumers_in_hydro']?></td>
                                                        <td><?= $total['N_consumers_out']?></td>
                                                        <td><?= $total['N_electric_total']?></td>
                                                        <td><?= $total['N_takeoff']?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="panel panel-danger">
                                            <div class="panel-heading">
                                                <h3 class="panel-title">
                                                    Альтернативная архитектура "<b><?= $currentArchitectureName;?></b>"
                                                </h3>
                                            </div>
                                            <div class="panel-body">
                                                <table class="table table-bordered table-condensed table-hover medium kv-table">
                                                    <tbody>
                                                    <tr class="danger">
                                                        <?php
                                                        $resultsEnergySourcesModel = new ResultsEnergySources();
                                                        ?>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('energySource_id');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('Qpump');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('Qdisposable');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('P_pump_out');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('Q_curr_to_Q_max');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_pump_out');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_pump_in');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_consumers_in_hydro');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_consumers_out');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_electric_total');?></th>
                                                        <th class="text-center"><?= $resultsEnergySourcesModel->getAttributeLabel('N_takeoff');?></th>
                                                    </tr>
                                                    <?php
                                                    $total['Qpump'] = 0;
                                                    $total['Qdisposable'] = 0;
                                                    $total['P_pump_out'] = 0;
                                                    $total['Q_curr_to_Q_max'] = 0;
                                                    $total['N_pump_out'] = 0;
                                                    $total['N_pump_in'] = 0;
                                                    $total['N_consumers_in_hydro'] = 0;
                                                    $total['N_consumers_out'] = 0;
                                                    $total['N_electric_total'] = 0;
                                                    $total['N_takeoff'] = 0;
                                                    foreach ($resultsEnergySourcesAlternative as $currentResultsEnergySourceAlternative) {
                                                        if ($currentResultsEnergySourceAlternative->flightMode_id == $currentFlightMode->id)
                                                        {
                                                            
                                                            $total['Qpump']+=$currentResultsEnergySourceAlternative->Qpump;
                                                            $total['Qdisposable']+=$currentResultsEnergySourceAlternative->Qdisposable;
                                                            $total['P_pump_out']+=$currentResultsEnergySourceAlternative->P_pump_out;
                                                            $total['Q_curr_to_Q_max']+=$currentResultsEnergySourceAlternative->Q_curr_to_Q_max;
                                                            $total['N_pump_out']+=$currentResultsEnergySourceAlternative->N_pump_out;
                                                            $total['N_pump_in']+=$currentResultsEnergySourceAlternative->N_pump_in;
                                                            $total['N_consumers_in_hydro']+=$currentResultsEnergySourceAlternative->N_consumers_in_hydro;
                                                            $total['N_consumers_out']+=$currentResultsEnergySourceAlternative->N_consumers_out;
                                                            $total['N_electric_total']+=$currentResultsEnergySourceAlternative->N_electric_total;
                                                            $total['N_takeoff']+=$currentResultsEnergySourceAlternative->N_takeoff;
                                                    ?>
                                                            <tr>
                                                                <td><?= $currentResultsEnergySourceAlternative->energySource->name;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->Qpump === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->Qpump;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->Qdisposable === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->Qdisposable;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->P_pump_out === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->P_pump_out;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->Q_curr_to_Q_max === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->Q_curr_to_Q_max;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->N_pump_out === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->N_pump_out;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->N_pump_in === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->N_pump_in;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->N_consumers_in_hydro === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->N_consumers_in_hydro;?></td>
                                                                <td><?= ($currentResultsEnergySourceAlternative->N_consumers_out === null) ? '&ndash;' : $currentResultsEnergySourceAlternative->N_consumers_out;?></td>
                                                                <td><?= $currentResultsEnergySourceAlternative->N_electric_total;?></td>
                                                                <td><?= $currentResultsEnergySourceAlternative->N_takeoff;?></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                    <tr style="border-top: 3px solid gray;">
                                                        <td><b>ВСЕГО</b></td>
                                                        <td><?= $total['Qpump']?></td>
                                                        <td><?= $total['Qdisposable']?></td>
                                                        <td><?= $total['P_pump_out']?></td>
                                                        <td><?= $total['Q_curr_to_Q_max']?></td>
                                                        <td><?= $total['N_pump_out']?></td>
                                                        <td><?= $total['N_pump_in']?></td>
                                                        <td><?= $total['N_consumers_in_hydro']?></td>
                                                        <td><?= $total['N_consumers_out']?></td>
                                                        <td><?= $total['N_electric_total']?></td>
                                                        <td><?= $total['N_takeoff']?></td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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