<?php

use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\widgets\ActiveForm;
use app\models\VehicleLayout;

//VarDumper::dump( $model, $depth = 10, $highlight = true);exit();

$form = ActiveForm::begin([
    'action' =>['powerdata/create'],
    'id' => 'create-form',
    'options' => ['class' => 'form-horizontal'],
]) ?>
  <table class="table table-sm">
    <tr>
        <td style="width:300px;vertical-align: middle;" align="left">
            <?= $form->field($model, 'consumer_id')?>
        </td><td style="width:70px;padding-top:35px;" align="center">
            <?= Html::submitButton('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' =>'Добавить потребителя', 'class' => 'btn btn-success'])?>
        </td>
    </tr>
</table>

<?php ActiveForm::end();

//echo Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' =>'Добавить потребителя', 'class' => 'btn btn-success', 'onclick' => '$("#content").load("powerdata/insertData");'])
?>