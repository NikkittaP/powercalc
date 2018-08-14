<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\Constants;

class ConstantsController extends Controller
{
    public function actionIndex()
    {
        $query = Constants::find()->indexBy('id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->request->post('hasEditable')) {
            $rowId = Yii::$app->request->post('editableKey');
            $model = Constants::findOne($rowId);

            $out = Json::encode(['output' => '', 'message' => '']);
            $posted = current($_POST['Constants']);
            $post = ['Constants' => $posted];

            if ($model->load($post)) {
                $model->save();

                $output = '';

                if (isset($posted['name'])) {
                    $output = $model->name;
                }
                if (isset($posted['value'])) {
                    $output = $model->value;
                }
                if (isset($posted['description'])) {
                    $output = $model->description;
                }

                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            return $out;
        }

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreate()
    {
        $model = new Constants();
        $model->save();

        return $this->redirect(['index']);
    }

    public function actionLoaddefaults()
    {
        $defaultData = [
            ['isEfficiencyFixed', '0', 'КПД fix?'],
            ['chartWidth', '1450', 'Ширина графика'],
            ['chartHeight', '850', 'Высота графика'],
            ['defaultChartColors', '#2f7ed8,#0d233a,#8bbc21,#910000,#1aadce,#492970,#f28f43,#77a1e5,#c42525,#a6c96a', 'Список стандартных цветов для графиков архитектур'],
        ];

        foreach ($defaultData as $record) {
            $model = new Constants();
            $model->name = $record[0];
            $model->value = $record[1];
            $model->description = $record[2];
            $model->save();
        }

        return $this->redirect(['index']);
    }

    public function actionTruncate()
    {
        $sql = "SET foreign_key_checks = 0;";
        $sql.= "TRUNCATE Constants;";
        $sql.= "SET foreign_key_checks = 1;";

        $connection = Yii::$app->getDb();
        $command = $connection->createCommand($sql);
        $command->execute();

        return $this->redirect(['index']);
    }
}