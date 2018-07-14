<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnergySourcesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Энергосистемы';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="energy-sources-index">

    <h1><?=Html::encode($this->title)?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <!--
    <p>
        <?=Html::a('Создать энергосистему', ['create'], ['class' => 'btn btn-success'])?>
    </p>
    -->

    <?=GridView::widget([
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
            'attribute' => 'architectureAvailability',
            'content' => function ($model, $key, $index, $column) use ($architecturesNames, $energySourceToArchitecture) {
                $out = '';
                foreach ($architecturesNames as $architectureName) {
                    $icon = '';
                    if ($energySourceToArchitecture[$model->id][$architectureName->id] == 0) {
                        $icon = '<span class="glyphicon glyphicon-remove text-danger"></span>';
                    } else if ($energySourceToArchitecture[$model->id][$architectureName->id] == 1) {
                        $icon = '<span class="glyphicon glyphicon-adjust text-warning"></span>';
                    } else if ($energySourceToArchitecture[$model->id][$architectureName->id] == 2) {
                        $icon = '<span class="glyphicon glyphicon-ok text-success"></span>';
                    }

                    $out .= $icon . '&nbsp;&nbsp;' . Html::a($architectureName->name, ['energy-sources/update', 'id' => $model->id, 'architecture_id' => $architectureName->id]) . '<br />';
                }
                return $out;
            },
        ],
        [
            'attribute' => 'qMax',
            'content' => function ($model, $key, $index, $column) use ($architecturesNames, $energySourceData) {
                $out = '';
                foreach ($architecturesNames as $architectureName) {
                    $value = $energySourceData[$model->id][$architectureName->id]["qMax"];

                    if ($value === null) {
                        $out .= '<span class="not-set">(не задано)</span><br />';
                    } else {
                        $out .= $value . '<br />';
                    }

                }
                return $out;
            },
        ],
        [
            'attribute' => 'pumpPressureNominal',
            'content' => function ($model, $key, $index, $column) use ($architecturesNames, $energySourceData) {
                $out = '';
                foreach ($architecturesNames as $architectureName) {
                    $value = $energySourceData[$model->id][$architectureName->id]["pumpPressureNominal"];

                    if ($value === null) {
                        $out .= '<span class="not-set">(не задано)</span><br />';
                    } else {
                        $out .= $value . '<br />';
                    }

                }
                return $out;
            },
        ],
        [
            'attribute' => 'pumpPressureWorkQmax',
            'content' => function ($model, $key, $index, $column) use ($architecturesNames, $energySourceData) {
                $out = '';
                foreach ($architecturesNames as $architectureName) {
                    $value = $energySourceData[$model->id][$architectureName->id]["pumpPressureWorkQmax"];

                    if ($value === null) {
                        $out .= '<span class="not-set">(не задано)</span><br />';
                    } else {
                        $out .= $value . '<br />';
                    }

                }
                return $out;
            },
        ],
        [
            'attribute' => 'NMax',
            'content' => function ($model, $key, $index, $column) use ($architecturesNames, $energySourceData) {
                $out = '';
                foreach ($architecturesNames as $architectureName) {
                    $value = $energySourceData[$model->id][$architectureName->id]["NMax"];

                    if ($value === null) {
                        $out .= '<span class="not-set">(не задано)</span><br />';
                    } else {
                        $out .= $value . '<br />';
                    }

                }
                return $out;
            },
        ],
        [
            'attribute' => 'energySourceLinked',
            'content' => function ($model, $key, $index, $column) use ($architecturesNames, $energySourceData) {
                $out = '';
                foreach ($architecturesNames as $architectureName) {
                    $value = $energySourceData[$model->id][$architectureName->id]["energySourceLinked_id"];

                    if ($value === null) {
                        $out .= '<span class="not-set">(не задано)</span><br />';
                    } else {
                        $out .= $value . '<br />';
                    }

                }
                return $out;
            },
        ],
    ],
]);?>
</div>
