<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\VehiclesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Импорт данных для компоновки "'.$vehicleLayoutNameModel->vehicle->name.': '.$vehicleLayoutNameModel->name.'"';
$this->params['breadcrumbs'][] = $this->title;

echo Html::a('Данные', ['power-data/index', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id], ['style' => 'font-size:18px;']);
echo '&nbsp;&nbsp;&nbsp;';
echo Html::a('Результаты', ['power-data/results', 'vehicleLayoutName_id' => $vehicleLayoutNameModel->id], ['style' => 'font-size:18px;']);
echo '&nbsp;&nbsp;&nbsp;';
echo '<span style="font-size:18px;">Импорт</span>';
echo '<br /><br />';
?>

<div class="power-data-import">
  
</div>