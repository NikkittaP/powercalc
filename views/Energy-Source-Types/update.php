<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\EnergySourceTypes */

$this->title = 'Обновить тип источника энергии: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Типы источников энергии', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="energy-source-types-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
