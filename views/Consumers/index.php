<?php

use yii\helpers\ArrayHelper;
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

    <h3>Выберите группу потребителей для отображения данных по ним:</h3>
    <?php
    echo Html::beginForm(['consumers/index'], 'post', ['class'=>'form-group']);
    echo Html::hiddenInput('isPost', '1');
    $items = ArrayHelper::map(app\models\ConsumerGroups::find()->all(), 'id', 'name');
    array_unshift($items,'Все');
    echo Html::dropDownList('selected_consumer_group', $selectedConsumerGroup, $items, ['class'=>'form-control', 'style'=>'width:300px;']);
    ?>
    <br />
    <div class="form-group">
        <?= Html::submitButton('Показать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>

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
