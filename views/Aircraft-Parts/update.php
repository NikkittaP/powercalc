<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\AircraftParts */

$this->title = 'Обновить зону аппарата: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Зоны аппарата', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="aircraft-parts-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
