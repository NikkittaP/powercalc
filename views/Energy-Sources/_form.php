<?php

use \app\models\EnergySources;
use \app\models\EnergySourceTypes;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\EnergySources */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="energy-sources-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php
    /*
    $items = ArrayHelper::map(EnergySourceTypes::find()->all(), 'id', 'name');
    echo $form->field($model, 'energySourceType_id')->radioList(
        $items,
        [
            'labelOptions' => array('style' => 'display:inline'),
            'separator' => '<br />',
        ]
    );
    */
    ?>

    <?php
    
    if ($energySource->energySourceType_id != 4)
    {
        echo $form->field($model, 'qMax')->textInput() ;
        echo $form->field($model, 'pumpPressureNominal')->textInput();
        echo $form->field($model, 'pumpPressureWorkQmax')->textInput();
    }
    ?>
    
    <?php
    if ($energySource->energySourceType_id == 4)
        echo $form->field($model, 'NMax')->textInput();

    if ($energySource->energySourceType_id == 2 || $energySource->energySourceType_id == 3)
    {
        $items = ArrayHelper::map(EnergySources::find()->where(['energySourceType_id'=>'4'])->all(), 'id', 'name');
        echo $form->field($model, 'energySourceLinked_id')->dropDownList($items);
    }
    ?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
