<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\VehiclesLayoutsNames */

$this->title = 'Обновить компоновку: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Компоновки', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="vehicles-layouts-names-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
