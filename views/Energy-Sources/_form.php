<?php

use \app\models\EnergySourceTypes;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnergySources */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="energy-sources-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

<div class="compactRadioGroup">
    <?php
        $items = ArrayHelper::map(EnergySourceTypes::find()->all(), 'id', 'name');
        echo $form->field($model, 'energySourceType_id')->radioList($items,
            array(
                'labelOptions'=>array('style'=>'display:inline'),
                'separator'=>'<br />',
            ));
    ?>
</div>

    <?= $form->field($model, 'qMax')->textInput() ?>

    <?= $form->field($model, 'pumpPressureNominal')->textInput() ?>

    <?= $form->field($model, 'pumpPressureWorkQmax')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
