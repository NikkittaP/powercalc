<?php

use yii\helpers\Html;

echo newerton\fancybox3\FancyBox::widget([
    'target' => '[data-fancybox]',
    'config' => [
    ]
]);

$this->title = 'Описание инструмента';
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Описание инструмента <?=Yii::$app->name?></h1>
    </div>

     <div class="body-content">
        <div>
            <h3>Описание Базы Данных</h3>
            <h4>Схема БД:</h4>
            <div class="text-center">
                <?= Html::a(Html::img('@web/documentation/db_scheme.png', ['width' => 900]), '@web/documentation/db_scheme.png', ['data-fancybox' => true]);?>
            </div>
            <p>
                В базе данных содержатся:
                <ul>
                    <li>В структурированном виде все исходные данные потребителей, аппаратов, компоновок, энергосистем и т.п.</li>
                    <li>Вспомогательные таблицы связей потребителей с компоновками, с архитектурами и с режимами полетов.</li>
                    <li>Результаты расчётов по потребителям и по энергосистемам.</li>
                </ul>

                Подробное описание таблиц поделено на 3 раздела.
                <ul>
                    <li>"Исходные" таблицы содержат начальные данные и доступны пользователю для изменения.</li>
                    <li>"Промежуточные" таблицы используются внутри инструмента для привязки одних исходных данных к другим с помощью уникальных идентификаторов исходных данных. Пользователь косвенно изменяет данные этих таблиц с помощью интерфейса пользователя.</li>
                    <li>"Расчётные" таблицы используются для хранения информации, полученной в ходе расчёта. Пользователь никак не может изменять данные этих таблиц. Более того планируется свести эти таблицы к статусу временных, то есть, например, они будут очищаться каждый месяц и наполняться заново путем итерационного расчёта всех доступных компоновок.</li>
                </ul>

                <h4>"Исходные" таблицы</h4>
                <ul>
                    <li><b>AircraftParts</b> &ndash; части аппарата (для привязки потребителя к определенной части аппарата).</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>name</b> &ndash; название части аппарата ["Крыло", "Нос"].</li>
                        </ul>
                    <li><b>Consumers</b> &ndash; потребители.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>name</b> &ndash; название потребителя ["Закрылки лев."].</li>
                            <li><b>aircraftPart_id</b> &ndash; связь с частю аппарата.</li>
                            <li><b>efficiencyHydro</b> &ndash; КПД гидро.</li>
                            <li><b>efficiencyElectric</b> &ndash; КПД электро.</li>
                            <li><b>q0</b> &ndash; Q0.</li>
                            <li><b>qMax</b> &ndash; Q потр.</li>
                        </ul>
                    <li><b>EnergySourceTypes</b> &ndash; типы энергосистем. Данный список является жёстко заданным и не подлежит изменению со стороны пользователя.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>name</b> &ndash; название типа энергосистемы ["Гидросистема", "Гидроэлектросистема", "Зональная гидроэлектросистема", "Электросистема"].</li>
                        </ul>
                    <li><b>EnergySources</b> &ndash; энергосистемы.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>name</b> &ndash; название энергосистемы ["ГС1", "ЛГС3", "ЭС1"].</li>
                            <li><b>energySourceType_id</b> &ndash; связь с типом энергосистемы.</li>
                            <li><b>qMax</b> &ndash; Qmax для расчёта Q располагаемого.</li>
                            <li><b>pumpPressureNominal</b> &ndash; Pнас ном.</li>
                            <li><b>pumpPressureWorkQmax</b> &ndash; Pнас раб при Qmax.</li>
                        </ul>
                    <li><b>FlightModes</b> &ndash; режимы полёта.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>name</b> &ndash; название режима полета ["Руление", "Взлёт"].</li>
                            <li><b>reductionFactor</b> &ndash; коэффициент понижения оборотов.</li>
                        </ul>
                    <li><b>Vehicles</b> &ndash; аппараты.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>name</b> &ndash; название аппарата ["Sukhoi Superjet 100", "Дрон 1", "МС-21"].</li>
                        </ul>
                    <li><b>VehiclesLayoutsNames</b> &ndash; компоновки для конкретного аппарата.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>vehicle_id</b> &ndash; связь с конкретным аппаратом.</li>
                            <li><b>name</b> &ndash; название модели (компоновки) ["Базовая модель", "Детальная модель"].</li>
                            Следующие столбцы принадлежат уже к "промежуточным" данным:
                            <li><b>usingArchitectures</b> &ndash; id используемых архитектур через пробел.</li>
                            <li><b>usingFlightModes</b> &ndash; id используемых режимов полета через пробел.</li>
                        </ul>
                    <li><b>ArchitecturesNames</b> &ndash; архитектуры для конкретной компоновки.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>vehicleLayoutName_id</b> &ndash; связь с конкретной компоновкой.</li>
                            <li><b>name</b> &ndash; название архитектуры для модели (компоновки) ["База", "БЭС1"].</li>
                            <li><b>isBasic</b> &ndash; является ли базовой архитектурой.</li>
                        </ul>
                </ul>
                <h4>"Промежуточные" таблицы</h4>
                <ul>
                    <li><b>VehicleLayout</b> &ndash; корневая таблица связей. Конкретно она связывает потребителя с компоновкой.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>vehicleLayoutName_id</b> &ndash; связь с конкретной компоновкой.</li>
                            <li><b>consumer_id</b> &ndash; связь с конкретным потребителем.</li>
                        </ul>
                    <li><b>Architecture_to_VehicleLayout</b> &ndash; связь компоновки, потребителя, архитектуры и выбранной энергосистемы.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>vehicleLayout_id</b> &ndash; связь с корневой таблицей связей.</li>
                            <li><b>architectureName_id</b> &ndash; связь с конкретной архитектурой.</li>
                            <li><b>energySource_id</b> &ndash; связь с конкретной энергосистемой.</li>
                        </ul>
                    <li><b>FlightModes_to_VehicleLayout</b> &ndash; связь компоновки, потребителя и режима полёта.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>vehicleLayout_id</b> &ndash; связь с корневой таблицей связей.</li>
                            <li><b>flightMode_id</b> &ndash; связь с конкретным режимом полёта.</li>
                            <li><b>usageFactor</b> &ndash; на сколько задействован потребитель на данном режиме полёта [0..1].</li>
                        </ul>
                </ul>
                <h4>"Расчётные" таблицы</h4>
                <ul>
                    <li><b>ResultsConsumers</b> &ndash; таблица с результатами расчёта по потребителям.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>vehicleLayoutName_id</b> &ndash; связь с конкретной компоновкой.</li>
                            <li><b>architectureName_id</b> &ndash; связь с конкретной архитектурой.</li>
                            <li><b>flightMode_id</b> &ndash; связь с конкретным режимом полёта.</li>
                            <li><b>consumer_id</b> &ndash; связь с конкретным потребителем.</li>
                            <li><b>consumption</b> &ndash; расход.</li>
                            <li><b>P_in</b> &ndash; Pin.</li>
                            <li><b>N_in_hydro</b> &ndash; Nin_гс.</li>
                            <li><b>N_out</b> &ndash; Nвых.</li>
                            <li><b>N_in_electric</b> &ndash; Nin_эс.</li>
                        </ul>
                    <li><b>ResultsEnergySources</b> &ndash; таблица с результатами расчёта по энергосистемам.</li>
                        <ul>
                            <li><b>id</b> &ndash; уникальный идентификатор.</li>
                            <li><b>vehicleLayoutName_id</b> &ndash; связь с конкретной компоновкой.</li>
                            <li><b>architectureName_id</b> &ndash; связь с конкретной архитектурой.</li>
                            <li><b>flightMode_id</b> &ndash; связь с конкретным режимом полёта.</li>
                            <li><b>consumer_id</b> &ndash; связь с конкретным потребителем.</li>
                            <li><b>Qpump</b> &ndash; Q нас.</li>
                            <li><b>Qdisposable</b> &ndash; Q распол.</li>
                            <li><b>P_pump_out</b> &ndash; P нас вых.</li>
                            <li><b>Q_curr_to_Q_max</b> &ndash; Qтек/Qmax.</li>
                            <li><b>N_pump_out</b> &ndash; N нас вых.</li>
                            <li><b>N_pump_in</b> &ndash; N нас вх.</li>
                            <li><b>N_consumers_in_hydro</b> &ndash; Nпотр_вх_гс.</li>
                            <li><b>N_consumers_out</b> &ndash; Nпотр_вых.</li>
                            <li><b>N_electric_total</b> &ndash; Nэс_всего.</li>
                            <li><b>N_takeoff</b> &ndash; Nотбора.</li>
                        </ul>
                </ul>
            </p>
        </div>
     </div>
</div>