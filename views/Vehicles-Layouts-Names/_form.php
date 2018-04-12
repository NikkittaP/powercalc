<?php

use \app\models\Vehicles;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\VehiclesLayoutsNames */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicles-layouts-names-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    $items = ArrayHelper::map(Vehicles::find()->all(), 'id', 'name');
    echo $form->field($model, 'vehicle_id')->dropDownList($items) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
