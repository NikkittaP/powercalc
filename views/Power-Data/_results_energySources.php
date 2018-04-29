<?php

use app\models\ResultsEnergySources;
?>

 <div class="row">
    <div class="col-sm-12">
        <h3 style="color:<?= $isBasic ? '#8a6d3b' : '#a94442';?>;"><?= $title;?></h3>
        <table class="table table-bordered table-condensed table-hover medium kv-table">
            <tbody>
            <tr class="<?= $isBasic ? 'warning' : 'danger';?>">
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
            $total['N_pump_out'] = 0;
            $total['N_pump_in'] = 0;
            $total['N_consumers_in_hydro'] = 0;
            $total['N_consumers_out'] = 0;
            $total['N_electric_total'] = 0;
            $total['N_takeoff'] = 0;
            foreach ($resultsEnergySources as $currentResultsEnergySources) {
                if ($currentResultsEnergySources->flightMode_id == $currentFlightMode->id)
                {
                    $flag = false;
                    if ($isBasic)
                        $flag = true;
                    else if ($currentResultsEnergySources->architectureName_id == $currentArchitectureID)
                        $flag = true;

                    if ($flag)
                    {
                        $total['Qpump'] +=                  $currentResultsEnergySources->Qpump;
                        $total['Qdisposable'] +=            $currentResultsEnergySources->Qdisposable;
                        $total['N_pump_out'] +=             $currentResultsEnergySources->N_pump_out;
                        $total['N_pump_in'] +=              $currentResultsEnergySources->N_pump_in;
                        $total['N_consumers_in_hydro'] +=   $currentResultsEnergySources->N_consumers_in_hydro;
                        $total['N_consumers_out'] +=        $currentResultsEnergySources->N_consumers_out;
                        $total['N_electric_total'] +=       $currentResultsEnergySources->N_electric_total;
                        $total['N_takeoff'] +=              $currentResultsEnergySources->N_takeoff;
            ?>
                        <tr>
                            <td><?= $currentResultsEnergySources->energySource->name;?></td>
                            <td><?= ($currentResultsEnergySources->Qpump === null) ? '&ndash;' : round($currentResultsEnergySources->Qpump, 1);?></td>
                            <td><?= ($currentResultsEnergySources->Qdisposable === null) ? '&ndash;' : round($currentResultsEnergySources->Qdisposable, 1);?></td>
                            <td><?= ($currentResultsEnergySources->P_pump_out === null) ? '&ndash;' : round($currentResultsEnergySources->P_pump_out, 1);?></td>
                            <td><?= ($currentResultsEnergySources->Q_curr_to_Q_max === null) ? '&ndash;' : round($currentResultsEnergySources->Q_curr_to_Q_max, 1);?></td>
                            <td><?= ($currentResultsEnergySources->N_pump_out === null) ? '&ndash;' : round($currentResultsEnergySources->N_pump_out, 1);?></td>
                            <td><?= ($currentResultsEnergySources->N_pump_in === null) ? '&ndash;' : round($currentResultsEnergySources->N_pump_in, 1);?></td>
                            <td><?= ($currentResultsEnergySources->N_consumers_in_hydro === null) ? '&ndash;' : round($currentResultsEnergySources->N_consumers_in_hydro, 1);?></td>
                            <td><?= ($currentResultsEnergySources->N_consumers_out === null) ? '&ndash;' : round($currentResultsEnergySources->N_consumers_out, 1);?></td>
                            <td><?= ($currentResultsEnergySources->N_electric_total === null) ? '&ndash;' : round($currentResultsEnergySources->N_electric_total, 1);?></td>
                            <td><?= ($currentResultsEnergySources->N_takeoff === null) ? '&ndash;' : round($currentResultsEnergySources->N_takeoff, 1);?></td>
                        </tr>
            <?php
                    }
                }
            }
            ?>
            <tr style="border-top: 3px solid gray;">
                <td><b>ВСЕГО</b></td>
                <td><?= round($total['Qpump'], 1);?></td>
                <td><?= round($total['Qdisposable'], 1);?></td>
                <td>&ndash;</td>
                <td>&ndash;</td>
                <td><?= round($total['N_pump_out'], 1);?></td>
                <td><?= round($total['N_pump_in'], 1);?></td>
                <td><?= round($total['N_consumers_in_hydro'], 1);?></td>
                <td><?= round($total['N_consumers_out'], 1);?></td>
                <td><?= round($total['N_electric_total'], 1);?></td>
                <td><?= round($total['N_takeoff'], 1);?></td>
            </tr>
            </tbody>
        </table>
    </div>
</div>