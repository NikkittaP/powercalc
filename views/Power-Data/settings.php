<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\web\JsExpression;
use app\models\ArchitecturesNames;

$this->title = 'Настройки для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'settings', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>

<div class="power-data-settings">
    <h3>Базовая архитектура:</h3>

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
            item = $(this);
            if (item.val() != id) {
                item.attr('disabled', false);
            } else {
                item.attr('checked', true);
                item.attr('disabled', true);
            }
        });
    }

    window.onload = function(){
        checkBasicArchitecture($("input:radio[name='settings_basicArchitecture']:checked").val(), true);
    }
JS;

$this->registerJs($script, yii\web\View::POS_HEAD);
?>

    <?php
        $items = ArrayHelper::map(ArchitecturesNames::find()->where(['vehicleLayoutName_id' => $vehicleLayoutNameModel->id])->all(), 'id', 'name');
        $selected = ArchitecturesNames::find()->where(['vehicleLayoutName_id' => $vehicleLayoutNameModel->id, 'isBasic' => 1])->one()->id;
        echo Html::radioList('settings_basicArchitecture', $selected, $items, [
            'labelOptions'=>array('style'=>'display:inline'),
            'separator'=>'<br />',
            'onchange'=>'checkBasicArchitecture(this, false)',
        ]);
    ?>

    <h3>Используемые архитектуры:</h3>
    <?php
        $items = ArrayHelper::map(ArchitecturesNames::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutNameModel->id])->all(), 'id', 'name');
        echo Html::checkboxList('settings_usingArchitectures', $usingArchitectures, $items,  [
            'item' => function ($index, $label, $name, $checked, $value) use($basicArchitecture) {
                return Html::checkbox($name, $checked, [
                    'value' => $value,
                    'label' => $label
                ]);
            },
            'separator'=>'<br />',
        ]);
    ?>


</div>