<?php

use yii\helpers\Html;

$this->title = 'Импорт данных для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo $this->render('_header_links', ['currentPage' => 'import', 'vehicleLayoutNameID' => $vehicleLayoutNameModel->id]);
?>

<div class="power-data-import">
    <?= Html::beginForm(['power-data/import', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id], 'post');?>
            <h3>Выберите файл для импорта данных:</h3>
            <h4 style="color:#a94442;">Для добавления нового файла с данными скопируйте его в папку <b><?= Yii::getAlias('@app').'\import\\';?></b></h4>
            <?php
                echo Html::radioList('selected_file', [], $listOfFiles, [
                    'labelOptions'=>array('style'=>'display:inline;'),
                    'separator'=>'<br />',
                ]);
            ?>
    <br /><br />
    <div class="form-group pull-left">
        <?= Html::submitButton('Импортировать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>
</div>