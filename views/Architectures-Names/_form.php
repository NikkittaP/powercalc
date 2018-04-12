<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use \app\models\VehiclesLayoutsNames;

/* @var $this yii\web\View */
/* @var $model app\models\ArchitecturesNames */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="architectures-names-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $vehiclesLayoutsNames = VehiclesLayoutsNames ::find()->all();
    foreach($vehiclesLayoutsNames as $vehicleLayoutName){
        $vehicleLayoutName->name = $vehicleLayoutName->vehicle->name.': '.$vehicleLayoutName->name;
    }
    $items =  ArrayHelper::map($vehiclesLayoutsNames, 'id', 'name');
    echo $form->field($model, 'vehicleLayoutName_id')->dropDownList($items) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
