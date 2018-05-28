<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\helpers\VarDumper;
use app\models\VehiclesLayoutsNames;

class SiteController extends Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }
    public function actionAbout()
    {
        return $this->render('about');
    }
    public function actionUpdatedb()
    {
        $connection = Yii::$app->getDb();
        $command = $connection->createCommand(file_get_contents(Yii::getAlias('@app').'\DB\powercalc.sql'));
        $command->execute();

        return $this->redirect(['index']);
    }
    public function actionTruncate()
    {
        $tables['AircraftParts'] = '[AircraftParts] Зоны аппарата';
        $tables['ArchitecturesNames'] = '[ArchitecturesNames] Архитектуры';
        $tables['Consumers'] = '[Consumers] Потребители';
        $tables['EnergySources'] = '[EnergySources] Энергосистемы';
        $tables['FlightModes'] = '[FlightModes] Режимы полета';

        $tables['VehicleLayout'] = '[VehicleLayout] Корневая таблица связей';
        $tables['Architecture_to_VehicleLayout'] = '[Architecture_to_VehicleLayout] Таблица связей потребителей с архитектурами и энергосистемами';
        $tables['FlightModes_to_VehicleLayout'] = '[FlightModes_to_VehicleLayout] Таблица связей потребителей с режимами полета';
        
        $tables['ResultsConsumers'] = '[ResultsConsumers] Таблица с результатами расчёта по потребителям';
        $tables['ResultsEnergySources'] = '[ResultsEnergySources] Таблица с результатами расчёта по энергосистемам';

        $post = \Yii::$app->request->post();
        if (isset($post['selected_tables'])) {
            $count = 0;
            $sql = "SET foreign_key_checks = 0;";
            foreach ($post['selected_tables'] as $key => $value) {
                if ($value == 'VehicleLayout')
                {
                    $models = VehiclesLayoutsNames::find()->all();
                    foreach ($models as $model) {
                        $model->usingArchitectures = null;
                        $model->usingFlightModes = null;
                        $model->save();
                    }
                }

                $sql.= "TRUNCATE ".$value.";";
                $count++;
            }
            $sql.= "SET foreign_key_checks = 1;";

            $connection = Yii::$app->getDb();
            $command = $connection->createCommand($sql);
            $command->execute();

            Yii::$app->session->setFlash('success', 'Таблицы были успешно очищены. Количество очищенных таблиц: <b>' . $count . '</b>.<br />Код SQL-запроса:<br />' . $sql);
        }

        return $this->render('truncate', [
            'tables' => $tables,
        ]);
    }
}
