<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Consumers */

$this->title = 'Обновить потребителя: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Потребители', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="consumers-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
