<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\VehiclesLayoutsNames */

$this->title = 'Создать компоновку';
$this->params['breadcrumbs'][] = ['label' => 'Компоновки', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicles-layouts-names-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
