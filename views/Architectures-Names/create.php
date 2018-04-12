<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\ArchitecturesNames */

$this->title = 'Создать архитектуру';
$this->params['breadcrumbs'][] = ['label' => 'Архтектуры', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="architectures-names-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
