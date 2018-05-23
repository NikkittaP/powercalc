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
}