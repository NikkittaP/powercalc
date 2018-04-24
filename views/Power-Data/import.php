<?php

$this->title = 'Импорт данных для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'import', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>

<div class="power-data-import">

</div>