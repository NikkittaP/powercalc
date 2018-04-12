<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ArchitecturesNamesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Архтектуры';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="architectures-names-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать архитектуру', ['create'], ['class' => 'btn btn-success']) ?>
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
            [
                'attribute' => 'vehicleLayoutName_id',
                'value' => function($model) { return $model->vehicleLayoutName->vehicle->name  . ": " . $model->vehicleLayoutName->name ;},
            ],
            'name',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
