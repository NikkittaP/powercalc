<?php

use yii\helpers\VarDumper;
use app\models\ResultsConsumers;
?>

<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-condensed table-hover medium kv-table">
            <tbody>
            <tr class="success">
                <?php
                $resultsConsumerModel = new ResultsConsumers();
                ?>
                <th class="text-center">ID</th>
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
                        <td><?= $currentResultsConsumersBasic->consumer->id;?></td>
                        <td><?= $currentResultsConsumersBasic->consumer->name;?></td>
                        <td><?= round($currentResultsConsumersBasic->consumption, 1);?></td>
                        <td><?= round($currentResultsConsumersBasic->P_in, 1);?></td>
                        <td><?= round($currentResultsConsumersBasic->N_in_hydro, 1);?></td>
                        <td><?= round($currentResultsConsumersBasic->N_out, 1);?></td>
                        <td><?= ($currentResultsConsumersAlternative->N_in_electric == null) ? '&ndash;' : round($currentResultsConsumersAlternative->N_in_electric, 1);?></td>
                    </tr>
            <?php
                }
            }
            ?>
                <tr style="border-top: 3px solid gray;">
                    <td colspan="2"><b>ВСЕГО</b></td>
                    <td>&ndash;</td>
                    <td>&ndash;</td>
                    <td>&ndash;</td>
                    <td>&ndash;</td>
                    <td><?= round($total['N_in_electric'], 1);?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>