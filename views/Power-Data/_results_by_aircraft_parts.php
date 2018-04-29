<div class="row">
    <div class="col-sm-12">
        <table class="table table-bordered table-condensed table-hover medium kv-table">
            <tbody>
            <tr class="active">
                <th rowspan="2"></th>
                <th colspan="<?=count($flightModeModel);?>" class="text-center"><h4><b>Nвых</b></h4></th>
            </tr>
            <tr class="active">
                <?php
                foreach ($flightModeModel as $currentFlightMode) {
                ?>
                <th class="text-center"><?= $currentFlightMode->name;?></th>
                <?php
                }
                ?>
            </tr>
            <?php
            foreach ($aircraftPartsModel as $currentAircraftPart) {
            ?>
            <tr>
                <td><b><?= $currentAircraftPart->name;?></b></td>
                <?php
                foreach ($flightModeModel as $currentFlightMode) {
                ?>
                <td>
                    <?= (isset($N_out_by_parts[$currentFlightMode->id][$currentAircraftPart->id])) 
                    ? $N_out_by_parts[$currentFlightMode->id][$currentAircraftPart->id] 
                    : '&ndash;';?>
                </td>
                <?php
                }
                ?>
            </tr>
            <?php
            }
            ?>
            </tbody>
        </table>
    </div>
</div>