<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnergySources */

$this->title = 'Обновить данные энергосистемы ' . $energySource->name . ' для архитектуры ' . $architectureName->name;
$this->params['breadcrumbs'][] = ['label' => 'Энергосистемы', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $energySource->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="energy-sources-update">

    <h1><?=Html::encode($this->title)?></h1>

    <?=$this->render('_form', [
    'energySource' => $energySource,
    'model' => $model,
])?>

</div>
