<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\AircraftParts */

$this->title = 'Создать часть аппарата';
$this->params['breadcrumbs'][] = ['label' => 'Части аппарата', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="aircraft-parts-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
