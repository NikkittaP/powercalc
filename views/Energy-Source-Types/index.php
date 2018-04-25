<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\EnergySourceTypesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Типы энергосистем';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="energy-source-types-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <h3 style="color:#a94442;">Данные типы жёстко заданы в коде расчёта с использованием ID. Поэтому запрещено любое изменение этих данных.</h3><br />
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?//= Html::a('Создать тип энергосистем', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            //['class' => 'yii\grid\SerialColumn'],

            'id',
            'name',

            //['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
