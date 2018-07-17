<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ConsumersSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Потребители';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="consumers-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать потребителя', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'contentOptions'=>['style'=>'width: 70px;']
            ],
            'name',
            [
                'attribute' => 'aircraftPart_id',
                'value' => 'aircraftPart.name',
            ],
            [
                'attribute' => 'consumerGroup_id',
                'value' => 'consumerGroup.name',
            ],
            [
                'attribute' => 'efficiencyHydro',
                'contentOptions'=>['style'=>'width: 150px;']
            ],
            [
                'attribute' => 'efficiencyElectric',
                'contentOptions'=>['style'=>'width: 150px;']
            ],
            [
                'attribute' => 'q0',
                'contentOptions'=>['style'=>'width: 100px;']
            ],
            [
                'attribute' => 'qMax',
                'contentOptions'=>['style'=>'width: 100px;']
            ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
