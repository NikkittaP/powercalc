<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use \app\models\AircraftParts;
use app\models\ConsumerGroups;

/* @var $this yii\web\View */
/* @var $model app\models\Consumers */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="consumers-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?php
    $items = ArrayHelper::map(AircraftParts::find()->all(), 'id', 'name');
    echo $form->field($model, 'aircraftPart_id')->dropDownList($items);
    
    $items2 = ArrayHelper::map(ConsumerGroups::find()->all(), 'id', 'name');
    echo $form->field($model, 'consumerGroup_id')->dropDownList($items2);
    ?>

    <?= $form->field($model, 'efficiencyHydro')->textInput() ?>

    <?= $form->field($model, 'efficiencyElectric')->textInput() ?>

    <?= $form->field($model, 'q0')->textInput() ?>

    <?= $form->field($model, 'qMax')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
