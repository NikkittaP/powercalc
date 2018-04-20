<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\EnergySources */

$this->title = 'Создать энергосистему';
$this->params['breadcrumbs'][] = ['label' => 'Энергосистемы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="energy-sources-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
