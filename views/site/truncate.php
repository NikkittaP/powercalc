<?php

use yii\helpers\Html;

$this->title = 'Очистка БД';
?>
<div class="site-truncate">
<?php
    $script = <<< JS
    
    function checkAll(flag) {
        var list = $('input[name="selected_tables[]"]');
        list.each(function () {
            $(this).attr('checked', flag);
        });
    }
JS;

$this->registerJs($script, yii\web\View::POS_HEAD);
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <h3 style="color:#FF0000;">
        ВНИМАНИЕ!
        <br />
        Данное действие <b>необратимо</b>. При очистке выбранных таблиц <b>ВСЕ</b> связанные данные будут окончательно уничтожены.
    </h3>
    <h3 style="color:#a94442;">
        Крайне рекомендуется очищать таблицы связей целиком.
        <br />
        То есть, при желании очистить одну из таблиц [VehicleLayout], [Architecture_to_VehicleLayout], [FlightModes_to_VehicleLayout] - стоит отметить для очистки оставшиеся две таблицы.
        <br />
        В ином случае не гарантируется работоспособность системы.
        <br />
        На данном этапе разработки данные связей очищаются для <b>ВСЕХ</b> компоновок.
    </h3>
    <h3 style="color:#40a73f;">
        Таблицы с результатами могут быть очищены в любой момент. Для их повторного наполнения необходимо заново произвести расчёт. 
    </h3><br />

    <h3>Выберите таблицы для очистки:</h3>
    <?php
    echo Html::beginForm(['site/truncate'], 'post');
    echo Html::checkboxList('selected_tables', [], $tables,  [
        'separator'=>'<br />',
    ]);
    echo '<br /><br />';
    echo Html::checkbox('select_all', false, ['label' => 'Выбрать все', 'onchange' => 'checkAll(this.checked)']);
    ?>
    <br /><br />
    <div class="form-group">
        <?= Html::submitButton('Очистить', [
            'data' => ['confirm' => 'Вы действительно хотите очистить выбранные таблицы?'],
            'class' => 'btn btn-primary'
            ]) ?>
    </div>
    <?= Html::endForm() ?>
</div>
