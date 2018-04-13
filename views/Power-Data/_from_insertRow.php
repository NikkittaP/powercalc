<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use app\models\VehicleLayout;
use kartik\widgets\Select2;

//VarDumper::dump( $model, $depth = 10, $highlight = true);exit();

$consumers = ArrayHelper::map(app\models\Consumers::find()->orderBy('name')->asArray()->all(), 'id', 'name');

$form = ActiveForm::begin([
    'action' =>['power-data/create'],
    'id' => 'create-form',
    'options' => [],
]) ?>
  <table class="table table-sm">
    <tr>
        <td style="width:300px;vertical-align: middle;" align="left">
            <?= Html::hiddenInput('vehicleLayoutName_id', $vehicleLayoutName_id); //$form->field($model, 'vehicleLayoutName_id')->hiddenInput(['value' => $vehicleLayoutName_id]); ?>
            <?= $form->field($model, 'consumer_id')->widget(Select2::classname(), [
                    'data' => $consumers,
                    'options' => ['placeholder' => 'Выберите потребителя...'],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]);
            ?>
        </td><td style="width:70px;padding-top:32px;" align="center">
            <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' =>'Добавить потребителя', 'class' => 'btn btn-success'])?>
        </td>
    </tr>
</table>

<?php ActiveForm::end();

//echo Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' =>'Добавить потребителя', 'class' => 'btn btn-success', 'onclick' => '$("#content").load("powerdata/insertData");'])
?>