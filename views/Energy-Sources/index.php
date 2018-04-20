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

            'id',
            'name',
            [
                'attribute' => 'energySourceType_id',
                'value' => 'energySourceType.name',
            ],
            'qMax',
            'pumpPressureNominal',
            'pumpPressureWorkQmax',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
