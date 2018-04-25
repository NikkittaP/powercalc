<?php

use yii\helpers\Html;

?>
<table>
    <tr>
        <td style="border-right:2px solid #333333;padding-left:15px;padding-right:15px;">
            <?php
            if ($currentPage=='import')
                echo '<span style="font-size:18px;">Импорт</span>';
            else
                echo Html::a('Импорт', ['power-data/import', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);
            ?>
        </td><td style="border-right:2px solid #333333;padding-left:15px;padding-right:15px;">
            <?php
            if ($currentPage=='settings')
                echo '<span style="font-size:18px;">Настройка</span>';
            else
                echo Html::a('Настройка', ['power-data/settings', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);
            ?>
        </td><td style="border-right:2px solid #333333;padding-left:15px;padding-right:15px;">
            <?php
            if ($currentPage=='data')
                echo '<span style="font-size:18px;">Данные</span>';
            else
                echo Html::a('Данные', ['power-data/index', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);
            ?>
        </td><td style="padding-left:15px;padding-right:15px;">
            <?php
            if ($currentPage=='results')
                echo '<span style="font-size:18px;">Результаты</span>';
            else
                echo Html::a('Результаты', ['power-data/results', 'vehicleLayoutName_id' => $vehicleLayoutNameID], ['style' => 'font-size:18px;']);
            ?>
        </td>
    </tr>
</table>
<hr />