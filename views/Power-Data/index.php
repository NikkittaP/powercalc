<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Заполнение данных для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="power-data-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php
    $consumers = ArrayHelper::map(app\models\Consumers::find()->orderBy('name')->asArray()->all(), 'id', 'name');

    $gridColumns = [
        [
            'attribute' => 'id',
            'width' => '70px',
            'hAlign' => 'center',
            'vAlign' => 'center',
        ],
        [
            'class' => 'kartik\grid\ExpandRowColumn',
            'width' => '50px',
            'value' => function ($model, $key, $index, $column) {
                return GridView::ROW_COLLAPSED;
            },
            'detail' => function ($model, $key, $index, $column) {
                return null;//Yii::$app->controller->renderPartial('_expand-row-details', ['model' => $model]);
            },
            'headerOptions' => ['class' => 'kartik-sheet-style'],
            'expandOneOnly' => true
        ],
        [
            'class' => 'kartik\grid\EditableColumn',
            'attribute' => 'consumer_id',
            'content'=>function ($model, $key, $index, $column) {
                return app\models\Consumers::findOne($model->consumer_id)->name;
            },
            'readonly' => false,
            'editableOptions' => [
                'asPopover' => false,
                'header' => 'Потребитель',
                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                'data'=>$consumers,
                'displayValueConfig'=>$consumers,
                'options' => ['class'=>'form-control', 'prompt'=>'Выберите потребителя...'],
            ],
        ],
    ];

    $architecturesNames = app\models\ArchitecturesNames::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutNameModel->id])->orderBy('name')->all();
    $energySources = ArrayHelper::map(app\models\EnergySources::find()->orderBy('name')->asArray()->all(), 'id', 'name');

    foreach ($architecturesNames as $architecturesName)
    {
        $gridColumns[] = [
            'class' => 'kartik\grid\EditableColumn',
            'attribute'=>'architectureToVehicleLayouts_'.$architecturesName->id,
            'value'=>function ($model, $key, $index, $column) use($architecturesName) {
                $m = app\models\ArchitectureToVehicleLayout::find()->where(['vehicleLayout_id'=>$model->id, 'architectureName_id'=>$architecturesName->id])->one();
                if ($m==null)
                    return '';
                return app\models\EnergySources::findOne($m->energySource_id)->name;
            },
            'readonly' => false,
            'editableOptions' => [
                'name' => 'architectureToVehicleLayouts_'.$architecturesName->id,
                'asPopover' => false,
                'header' => 'Источник энергии',
                'inputType' => \kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                'data'=>$energySources,
                'displayValueConfig'=>$energySources,
                'options' => ['class'=>'form-control', 'prompt'=>'Выберите источник энергии...'],
            ],
        ];
    }

    //\yii\helpers\VarDumper::dump($searchModel->rules(), 15, true);exit();

    echo GridView::widget([
        'dataProvider'=> $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $gridColumns,
        'toolbar' =>  [
            ['content' =>
                Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' =>'Добавить потребителя', 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");'])
            ],
            '{export}',
        ],
        'export' => [
            'fontAwesome' => false,
        ],
        'striped' => true,
        'responsive'=>true,
        'hover'=>true,
        'panel' => [
            'type' => GridView::TYPE_PRIMARY,
            'heading' => 'Заполнение данных для компоновки "<b>'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'</b>"',
        ],
    ]);
    ?>
</div>