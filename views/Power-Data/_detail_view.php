<?php

$consumer = app\models\Consumers::findOne($model->consumer_id);

$architectureToVehicleLayouts = app\models\ArchitectureToVehicleLayout::find()->where(['vehicleLayout_id'=>$model->id])->all();

?>

<div style="width:90%">
<h3>Детали записи #<?=$model->id;?></h3>

<div class="row">
    <div class="col-sm-3">
        <table class="table table-bordered table-condensed table-hover small kv-table">
            <tbody>
            <tr class="warning">
                <th colspan="2" class="text-center text-warning"><?= $consumer->name;?></th>
            </tr>
            <tr>
                <td>Часть аппарата</td><td class="text-right"><?=$consumer->aircraftPart->name;?></td>
            </tr>
            <tr>
                <td>КПД гидро</td><td class="text-right"><?=$consumer->efficiencyHydro;?></td>
            </tr>
            <tr>
                <td>КПД электро</td><td class="text-right"><?=$consumer->efficiencyElectric;?></td>
            </tr>
            <tr>
                <td>Q0</td><td class="text-right"><?=$consumer->q0;?></td>
            </tr>
            <tr>
                <td>Q потр</td><td class="text-right"><?=$consumer->qMax;?></td>
            </tr>
            </tbody>
        </table>
    </div>
    <div class="col-sm-9">
        <div class="row">
            <?php
            foreach($architectureToVehicleLayouts as $architectureToVehicleLayout)
            {
            ?>
                <div class="col-sm-4">
                    <table class="table table-bordered table-condensed table-hover small kv-table">
                        <tbody>
                        <tr class="success">
                            <th colspan="2" class="text-center text-warning"><?= $architectureToVehicleLayout->energySource->name;?></th>
                        </tr>
                        <tr>
                            <td>Тип энергосистемы</td><td class="text-right">
                                <?= $architectureToVehicleLayout->energySource->energySourceType->name;?>
                            </td>
                        </tr>
                        <tr>
                            <td>Q max</td><td class="text-right"><?=($architectureToVehicleLayout->energySource->qMax==null) ? '-' : $architectureToVehicleLayout->energySource->qMax;?></td>
                        </tr>
                        <tr>
                            <td>Pнас ном</td><td class="text-right"><?=($architectureToVehicleLayout->energySource->pumpPressureNominal==null) ? '-' : $architectureToVehicleLayout->energySource->pumpPressureNominal;?></td>
                        </tr>
                        <tr>
                            <td>P нас раб при Q max</td><td class="text-right"><?=($architectureToVehicleLayout->energySource->pumpPressureWorkQmax==null) ? '-' : $architectureToVehicleLayout->energySource->pumpPressureWorkQmax;?></td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php
            }
            ?>
        </div>
    </div>
</div>
</div>