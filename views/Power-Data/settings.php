<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use app\models\ArchitecturesNames;

$this->title = 'Настройки для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'settings', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>

<div class="power-data-settings">
    <?php
        $items = ArrayHelper::map(ArchitecturesNames::find(['vehicleLayoutName_id' => $vehicleLayoutNameModel->id])->all(), 'id', 'name');
        $selected = ArchitecturesNames::find()->where(['vehicleLayoutName_id' => $vehicleLayoutNameModel->id, 'isBasic' => 1])->one()->id;
        echo Html::radioList('namenamename', $selected, $items, [
            'labelOptions'=>array('style'=>'display:inline'),
            'separator'=>'<br />',
        ]);
    ?>
</div>