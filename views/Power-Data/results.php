<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\VarDumper;
use yii\data\ActiveDataProvider;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

use \app\models\ArchitecturesNames;
use app\models\ResultsConsumers;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Результаты расчёта для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="power-data-results">

    <h3>Выберите архитектуры для отображения результатов по ним:</h3>
    <?php
    echo Html::beginForm(['power-data/results', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id],'post');
    $items = ArrayHelper::map(ArchitecturesNames::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutNameModel->id])->all(), 'id', 'name');
    echo Html::checkboxList('selected_architectures', $selectedArchitectures, $items,  [
        'item' => function ($index, $label, $name, $checked, $value) use($basicArchitecture) {
            return Html::checkbox($name, $checked, [
                'value' => $value,
                'disabled' => $value == key($basicArchitecture),
                'label' => $label
            ]);
        },
        'separator'=>'<br />',
    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Показать', ['class' => 'btn btn-primary']) ?>
    </div>
    <?= Html::endForm() ?>

<?php
foreach ($alternativeArchitectures as $currentArchitectureID => $currentArchitectureName) {
?>
    <div class="panel panel-primary">
        <div class="panel-heading">
            <h3 class="panel-title">
                Сравнение базовой архитектуры "<b><?= current($basicArchitecture);?></b>" с альтернативной "<b><?= $currentArchitectureName;?></b>"
            </h3>
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-sm-12">
                    <table class="table table-bordered table-condensed table-hover medium kv-table">
                        <tbody>
                        <tr class="success">
                            <?php
                            $resultsConsumerModel = new ResultsConsumers();
                            ?>
                            <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('flightMode_id');?></th>
                            <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('consumer_id');?></th>
                            <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('consumption');?></th>
                            <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('P_in');?></th>
                            <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('N_in_hydro');?></th>
                            <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('N_out');?></th>
                            <th class="text-center"><?= $resultsConsumerModel->getAttributeLabel('N_in_electric');?></th>
                        </tr>
                        <?php
                            
                        ?>
                            <tr>
                                <td><?= $resultsConsumersBasic->flightMode->name;?></td>
                                <td><?= $resultsConsumersBasic->consumer->name;?></td>
                                <td><?= $resultsConsumersBasic->consumption;?></td>
                            </tr>
                        <?php
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

<?php
}
?>

    <?php
    
    /*
    $dataProviderResultsConsumers = new ActiveDataProvider([
        'query' => $resultsConsumers,
        'pagination' => false,
    ]);
    $gridColumnsResultsConsumers = [
        [
            'attribute' => 'architectureName_id',
            'value' => 'architectureName.name',
        ],
        [
            'attribute' => 'flightMode_id',
            'value' => 'flightMode.name',
        ],
        [
            'attribute' => 'consumer_id',
            'value' => 'consumer.name',
        ],
        'consumption',
        'P_in',
        'N_in_hydro',
        'N_out',
        'N_in_electric',
    ];

    echo GridView::widget([
        'dataProvider'=> $dataProviderResultsConsumers,
        'columns' => $gridColumnsResultsConsumers,
        'toolbar' =>  [
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
            'heading' => 'Результаты расчёта для компоновки "<b>'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'</b>"',
        ],
    ]);
    */
    ?>
</div>