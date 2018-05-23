<?php

namespace app\controllers;

use Yii;
use yii\helpers\Json;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use app\models\PumpEfficiency;

class EfficiencyController extends Controller
{
    public function actionPump()
    {
        $query = PumpEfficiency::find()->indexBy('id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->request->post('hasEditable')) {
            $rowId = Yii::$app->request->post('editableKey');
            $model = PumpEfficiency::findOne($rowId);

            $out = Json::encode(['output' => '', 'message' => '']);
            $posted = current($_POST['PumpEfficiency']);
            $post = ['PumpEfficiency' => $posted];

            if ($model->load($post)) {
                $model->save();

                $output = '';

                if (isset($posted['QCurQmax'])) {
                    $output = Yii::$app->formatter->asDecimal($model->QCurQmax, 4);
                }
                if (isset($posted['pumpEfficiency'])) {
                    $output = Yii::$app->formatter->asDecimal($model->pumpEfficiency, 4);
                }
                if (isset($posted['pumpEfficiencyRK'])) {
                    $output = Yii::$app->formatter->asDecimal($model->pumpEfficiencyRK, 4);
                }

                $out = Json::encode(['output' => $output, 'message' => '']);
            }
            return $out;
        }

        return $this->render('pump', [
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionCreatepump()
    {
        $model = new PumpEfficiency();
        $model->save();

        return $this->redirect(['pump']);
    }

    public function actionLoaddefaults()
    {
        $defaultData = [
            [0.0000, 0.0000, 0.0000],
            [0.0300, 0.2000, 0.1900],
            [0.0600, 0.3200, 0.3010],
            [0.1250, 0.4600, 0.4320],
            [0.2500, 0.6300, 0.5920],
            [0.3750, 0.7250, 0.6820],
            [0.5000, 0.7900, 0.7430],
            [0.7500, 0.8550, 0.8037],
            [1.0000, 0.8850, 0.8319]
        ];

        foreach ($defaultData as $record) {
            $model = new PumpEfficiency();
            $model->QCurQmax = $record[0];
            $model->pumpEfficiency = $record[1];
            $model->pumpEfficiencyRK = $record[2];
            $model->save();
        }

        return $this->redirect(['pump']);
    }
}