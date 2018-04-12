<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ConsumersSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consumers-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'aircraftPart_id') ?>

    <?= $form->field($model, 'efficiencyHydro') ?>

    <?= $form->field($model, 'efficiencyElectric') ?>

    <?= $form->field($model, 'q0') ?>

    <?= $form->field($model, 'qMax') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
