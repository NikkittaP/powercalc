<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Vehicles */

$this->title = 'Создать аппарат';
$this->params['breadcrumbs'][] = ['label' => 'Аппараты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vehicles-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
