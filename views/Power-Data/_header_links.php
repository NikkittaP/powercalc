<?php

use yii\helpers\Html;


if ($currentPage=='import')
    echo '<span style="font-size:18px;">Импорт</span>';
else
    echo Html::a('Импорт', ['power-data/import', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);

echo '&nbsp;&nbsp;&nbsp;';

if ($currentPage=='settings')
    echo '<span style="font-size:18px;">Настройка</span>';
else
    echo Html::a('Настройка', ['power-data/settings', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);

echo '&nbsp;&nbsp;&nbsp;';

if ($currentPage=='data')
    echo '<span style="font-size:18px;">Данные</span>';
else
    echo Html::a('Данные', ['power-data/index', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);

echo '&nbsp;&nbsp;&nbsp;';

if ($currentPage=='results')
    echo '<span style="font-size:18px;">Результаты</span>';
else
    echo Html::a('Результаты', ['power-data/results', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);


echo '<br /><br />';
?>