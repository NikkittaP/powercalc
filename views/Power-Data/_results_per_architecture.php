<?php

use yii\bootstrap\Tabs;
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