<br />

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