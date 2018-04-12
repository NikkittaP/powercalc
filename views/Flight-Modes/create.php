<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\FlightModes */

$this->title = 'Создать режим полета';
$this->params['breadcrumbs'][] = ['label' => 'Режимы полета', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="flight-modes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
