<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnergySourcesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Энергосистемы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="energy-sources-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать энергосистему', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions' => ['style' => 'width:30px;'],
            ],
            'name',
            [
                'attribute' => 'energySourceType_id',
                'value' => 'energySourceType.name',
            ],
            [
                'attribute' => 'qMax',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->energySourceType_id == 4)
                        return '-';

                    return $model->qMax;
                },
            ],
            [
                'attribute' => 'pumpPressureNominal',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->energySourceType_id == 4)
                        return '-';

                    return $model->pumpPressureNominal;
                },
            ],
            [
                'attribute' => 'pumpPressureWorkQmax',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->energySourceType_id == 4)
                        return '-';

                    return $model->pumpPressureWorkQmax;
                },
            ],
            [
                'attribute' => 'NMax',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->energySourceType_id != 4)
                        return '-';

                    return $model->NMax;
                },
            ],
            [
                'attribute' => 'energySourceLinked_id',
                'value' => function ($model, $key, $index, $column) {
                    if ($model->energySourceType_id != 2 && $model->energySourceType_id != 3)
                        return '-';

                    return $model->energySourceLinked->name;
                },
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
