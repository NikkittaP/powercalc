<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\ConsumerGroups */

$this->title = 'Обновить группу потребителей: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Группы потребителей', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="consumer-groups-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
