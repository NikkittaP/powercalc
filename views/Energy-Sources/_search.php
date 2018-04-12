<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnergySourcesSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="energy-sources-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'isElectric') ?>

    <?= $form->field($model, 'qMax') ?>

    <?= $form->field($model, 'pumpPressureNominal') ?>

    <?= $form->field($model, 'pumpPressureWorkQmax') ?>

    <div class="form-group">
        <?= Html::submitButton('Поиск', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Сброс', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
