<?php

/* @var $this yii\web\View */

use \app\models\AircraftParts;
use \app\models\ArchitecturesNames;
use \app\models\Consumers;
use \app\models\EnergySources;
use \app\models\EnergySourceTypes;
use \app\models\FlightModes;
use \app\models\Vehicles;
use \app\models\VehiclesLayoutsNames;
use yii\helpers\Html;

$this->title = 'PowerCalc - Инструмент для анализа энергетических систем';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?=Yii::$app->name?></h1>

        <p class="lead">Инструмент для анализа энергетических систем</p>
    </div>

    <div style="text-align:center;margin-top:-50px;padding-bottom:50px;">
    <?php
        echo Html::a('Обновить структуру БД', ['/site/updatedb'], [
            'class' => 'btn btn-warning',
            'data' => [
                'confirm' => 'Все текущие данные будут безвозвратно удалены из БД! Вы действительно хотите продолжить?',
                'method' => 'post',
            ],
            ]);
    ?>
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-3"></div>
            <div class="col-lg-6">
                <div class="panel panel-primary" style = "border-color: black;">
                    <div class="panel-heading" style = "background-color: black;">
                        <h3 class="panel-title">
                            <?= Html::a('Компоновки', ['vehicles-layouts-names/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $vehiclesLayoutsNames = VehiclesLayoutsNames::find()->all();
                            foreach ($vehiclesLayoutsNames as $vehiclesLayoutsName)
                            {
                                echo '<tr><td>';
                                echo Html::a($vehiclesLayoutsName->name.' ('.$vehiclesLayoutsName->vehicle->name.')', ['vehicles-layouts-names/view', 'id' => $vehiclesLayoutsName->id]);
                                echo '</td><td>';
                                echo Html::a('Импорт', ['power-data/import', 'vehicleLayoutName_id' => $vehiclesLayoutsName->id]);
                                echo ' </td><td>';
                                echo Html::a('Настройки', ['power-data/settings', 'vehicleLayoutName_id' => $vehiclesLayoutsName->id]);
                                echo ' </td><td>';
                                echo Html::a('Данные', ['power-data/index', 'vehicleLayoutName_id' => $vehiclesLayoutsName->id]);
                                echo '</td><td>';
                                echo Html::a('Результаты', ['power-data/results', 'vehicleLayoutName_id' => $vehiclesLayoutsName->id]);
                                echo '</td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-color: black;background-color: black;" />
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Аппараты', ['vehicles/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                        <?php
                        $vehicles = Vehicles::find()->all();
                        foreach ($vehicles as $vehicle)
                        {
                            echo '<tr><td>';
                            echo Html::a($vehicle->name, ['vehicles/view', 'id' => $vehicle->id]);
                            echo ' </td></tr>';
                        }
                        ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Архитектуры', ['architectures-names/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $architecturesNames = ArchitecturesNames::find()->all();
                            foreach ($architecturesNames as $architectureName)
                            {
                                echo '<tr><td>';
                                echo Html::a($architectureName->name. ' ('.$architectureName->vehicleLayoutName->name.' ('.$architectureName->vehicleLayoutName->vehicle->name.'))', ['architectures-names/view', 'id' => $architectureName->id]);
                                echo ' </td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Режимы полёта', ['flight-modes/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $flightModes = FlightModes::find()->count();
                            echo '<tr><td>';
                            echo '<i>Всего '.$flightModes.' режимов полёта</i>';
                            echo ' </td></tr>';
                            //foreach ($flightModes as $flightMode)
                            //{
                            //    echo '<tr><td>';
                            //    echo Html::a($flightMode->name, ['flight-modes/view', 'id' => $flightMode->id]);
                            //   echo ' </td></tr>';
                            //}
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-color: black;background-color: black;" />
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Типы энергосистем', ['energy-source-types/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $energySourceTypes = EnergySourceTypes::find()->all();
                            foreach ($energySourceTypes as $energySourceType)
                            {
                                echo '<tr><td>';
                                echo Html::a($energySourceType->name, ['energy-source-types/view', 'id' => $energySourceType->id]);
                                echo ' </td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Энергосистемы', ['energy-sources/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $energySources = EnergySources::find()->all();
                            foreach ($energySources as $energySource)
                            {
                                echo '<tr><td>';
                                echo Html::a($energySource->name, ['energy-sources/view', 'id' => $energySource->id]);
                                echo ' </td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <hr style="border-color: black;background-color: black;" />
        <div class="row">
            <div class="col-lg-2"></div>
            <div class="col-lg-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Зоны аппарата', ['aircraft-parts/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $aircraftParts = AircraftParts::find()->all();
                            foreach ($aircraftParts as $aircraftPart)
                            {
                                echo '<tr><td>';
                                echo Html::a($aircraftPart->name, ['aircraft-parts/view', 'id' => $aircraftPart->id]);
                                echo ' </td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Потребители', ['consumers/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $consumers = Consumers::find()->count();
                            echo '<tr><td>';
                            echo '<i>Всего '.$consumers.' потребителей</i>';
                            echo ' </td></tr>';
                            //foreach ($consumers as $consumer)
                            //{
                            //    echo '<tr><td>';
                            //    echo Html::a($consumer->name, ['consumers/view', 'id' => $consumer->id]);
                            //    echo ' </td></tr>';
                            //}
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>