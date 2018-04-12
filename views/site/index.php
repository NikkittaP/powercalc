<?php

/* @var $this yii\web\View */

use \app\models\AircraftParts;
use \app\models\ArchitecturesNames;
use \app\models\Consumers;
use \app\models\EnergySources;
use \app\models\FlightModes;
use \app\models\Vehicles;
use \app\models\VehiclesLayoutsNames;
use yii\helpers\Html;

$this->title = 'PowerCalc';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1><?=Yii::$app->name?></h1>

        <p class="lead">Инструмент для анализа энергетических систем</p>

        <!--
        <p><a class="btn btn-lg btn-success" href="http://www.yiiframework.com">Get started with Yii</a></p>
        -->
    </div>

    <div class="body-content">
        <div class="row">
            <div class="col-lg-4">
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
                                echo Html::a('Данные', ['power-data/index', 'vehicleLayoutName_id' => $vehiclesLayoutsName->id]);
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
                            <?= Html::a('Части аппарата', ['aircraft-parts/index']) ?>
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
            <div class="col-lg-2">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title">
                            <?= Html::a('Источники энергии', ['energy-sources/index']) ?>
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

        <div class="row">
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
                            $consumers = Consumers::find()->all();
                            foreach ($consumers as $consumer)
                            {
                                echo '<tr><td>';
                                echo Html::a($consumer->name, ['consumers/view', 'id' => $consumer->id]);
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
                            <?= Html::a('Режимы полёта', ['flight-modes/index']) ?>
                        </h3>
                    </div>

                    <div class="panel-body" style="padding:0px;">
                        <table class="table table-striped">

                            <?php
                            $flightModes = FlightModes::find()->all();
                            foreach ($flightModes as $flightMode)
                            {
                                echo '<tr><td>';
                                echo Html::a($flightMode->name, ['flight-modes/view', 'id' => $flightMode->id]);
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
                                echo Html::a($architectureName->name, ['architectures-names/view', 'id' => $architectureName->id]);
                                echo ' </td></tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
