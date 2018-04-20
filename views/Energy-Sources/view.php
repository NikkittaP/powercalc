<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\EnergySources */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Энергосистемы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="energy-sources-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены что хотите удалить этот элемент?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => 'Тип энергосистемы',
                'attribute' => 'energySourceType.name',
            ],
            'qMax',
            'pumpPressureNominal',
            'pumpPressureWorkQmax',
        ],
    ]) ?>

</div>
