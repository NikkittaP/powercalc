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
            ['chartWidth', '1450'],
            ['chartHeight', '600'],
        ];

        foreach ($defaultData as $record) {
            $model = new Constants();
            $model->name = $record[0];
            $model->value = $record[1];
            $model->save();
        }

        return $this->redirect(['index']);
    }
}