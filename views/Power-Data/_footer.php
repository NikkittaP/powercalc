<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use app\models\VehicleLayout;
use kartik\widgets\Select2;

$form = ActiveForm::begin([
    'action' =>['power-data/calculate'],
    'id' => 'create-form',
    'options' => [],
]) ?>
<div class="row pull-right" style="margin-right:10px;margin-top:-20px;margin-bottom:10px;">
    <?= Html::hiddenInput('vehicleLayoutName_id', $vehicleLayoutName_id);?>
    <?= Html::submitButton('<i class="glyphicon glyphicon-play"></i>&nbsp;&nbsp;&nbsp;&nbsp;Рассчитать', ['type' => 'button', 'title' =>'Рассчитать', 'class' => 'btn btn-success'])?>
</div>

<?php ActiveForm::end();
?>