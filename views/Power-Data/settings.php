<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\JsExpression;
use app\models\ArchitecturesNames;
use app\models\FlightModes;

$this->title = 'Настройки для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'settings', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>

<div class="power-data-settings">
<?php
    $script = <<< JS
    
    function checkBasicArchitecture(element, flag) {
        var id;
        if (flag)
            id = element;
        else
            id = $(element).find('input:checked').val();
        var list = $('input[name="settings_usingArchitectures[]"]');
        list.each(function () {
            if (this.value != id) {
                this.disabled = false;
            } else {
                this.checked = true;
                this.disabled = true;
            }
        });
    }

    window.onload = function(){
        checkBasicArchitecture($("input:radio[name='settings_basicArchitecture']:checked").val(), true);
    }

    function checkAllArchitectures(flag) {
        var list = $('input[name="settings_usingArchitectures[]"]');
        list.each(function () {
            this.checked = flag;
        });
        
        checkBasicArchitecture($("input:radio[name='settings_basicArchitecture']:checked").val(), true);
    }

    function checkAllFlightModes(flag) {
        var list = $('input[name="settings_usingFlightModes[]"]');
        list.each(function () {
            this.checked = flag;
        });
    }
JS;

$this->registerJs($script, yii\web\View::POS_HEAD);
?>

    <?= Html::beginForm(['power-data/settings', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id],'post');?>
    <div class="row">
        <div class="col-sm-4">
            <h3>Базовая архитектура:</h3>
            <?php
                $items = ArrayHelper::map(ArchitecturesNames::find()->where(['vehicleLayoutName_id' => $vehicleLayoutNameModel->id])->all(), 'id', 'name');
                $selected = ArchitecturesNames::find()->where(['vehicleLayoutName_id' => $vehicleLayoutNameModel->id, 'isBasic' => 1])->one()->id;
                echo Html::radioList('settings_basicArchitecture', $selected, $items, [
                    'labelOptions'=>array('style'=>'display:inline'),
                    'separator'=>'<br />',
                    'onchange'=>'checkBasicArchitecture(this, false)',
                ]);
            ?>
        </div>

        <div class="col-sm-4">
            <h3>Используемые архитектуры:</h3>
            <?php
                $items = ArrayHelper::map(ArchitecturesNames::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutNameModel->id])->all(), 'id', 'name');
                echo Html::checkboxList('settings_usingArchitectures', $usingArchitectures, $items,  [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return Html::checkbox($name, $checked, [
                            'value' => $value,
                            'label' => $label
                        ]);
                    },
                    'separator'=>'<br />',
                ]);
                echo '<br /><br />';
                echo Html::checkbox('select_all_architectures', false, ['label' => 'Выбрать все', 'onchange' => 'checkAllArchitectures(this.checked)']);
            ?>
        </div>

        <div class="col-sm-4">
            <h3>Используемые режимы полета:</h3>
            <?php
                $items = ArrayHelper::map(FlightModes::find()->all(), 'id', 'name');
                echo Html::checkboxList('settings_usingFlightModes', $usingFlightModes, $items,  [
                    'item' => function ($index, $label, $name, $checked, $value) {
                        return Html::checkbox($name, $checked, [
                            'value' => $value,
                            'label' => $label
                        ]);
                    },
                    'separator'=>'<br />',
                ]);
                echo '<br /><br />';
                echo Html::checkbox('select_all_flight_modes', false, ['label' => 'Выбрать все', 'onchange' => 'checkAllFlightModes(this.checked)']);
            ?>
        </div>
    </div>
    <br /><br />
    <div class="form-group pull-right">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>