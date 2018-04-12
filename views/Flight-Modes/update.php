<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\FlightModes */

$this->title = 'Обновить режим полета: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Режимы полета', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="flight-modes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
