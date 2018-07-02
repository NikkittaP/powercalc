<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use \app\models\VehiclesLayoutsNames;
use \app\models\Constants;
use kartik\color\ColorInput;

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

    <?= $form->field($model, 'isBasic')->checkbox() ?>

    <?= $form->field($model, 'chartColor')->widget(ColorInput::classname(), [
        'options' => ['placeholder' => 'Выберите цвет...'],
        'showDefaultPalette' => false,
        'pluginOptions' => [
            'showAlpha' => false,
            'palette' => [
                Constants::getValue('defaultChartColors')
            ],
        ],
    ]);
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
