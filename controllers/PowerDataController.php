<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\VehicleLayout;
use \app\models\VehicleLayoutSearch;
use \app\models\VehiclesLayoutsNames;

/**
 * VehiclesController implements the CRUD actions for Vehicles model.
 */
class PowerDataController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex($vehicleLayoutName_id)
    {
        $vehicleLayoutNameModel = $this->findModelVehicleLayoutNames($vehicleLayoutName_id);
        $searchModel = new VehicleLayoutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $vehicleLayoutName_id);

        if (Yii::$app->request->post('hasEditable')) {
            $data = Yii::$app->request->post();


            $rowId = Yii::$app->request->post('editableKey');
            $model = VehicleLayout::findOne($rowId);

            // store a default json response as desired by editable
            $out = Json::encode(['output'=>'', 'message'=>implode($data)]);

            // fetch the first entry in posted data (there should only be one entry
            // anyway in this array for an editable submission)
            // - $posted is the posted data for Book without any indexes
            // - $post is the converted array for single model validation
            $posted = current($_POST['VehicleLayout']);
            $post = ['VehicleLayout' => $posted];

            // load model like any single model validation
            if ($model->load($post)) {
                // can save model or do something before saving model
                $model->save();

                // custom output to return to be displayed as the editable grid cell
                // data. Normally this is empty - whereby whatever value is edited by
                // in the input by user is updated automatically.
                $output = '';

                if (isset($posted['consumer_id']))
                {
                    $output =  $model->consumer_id;
                }

                // specific use case where you need to validate a specific
                // editable column posted when you have more than one
                // EditableColumn in the grid view. We evaluate here a
                // check to see if buy_amount was posted for the Book model
                //if (isset($posted['buy_amount'])) {
                //    $output = Yii::$app->formatter->asDecimal($model->buy_amount, 2);
                //}

                // similarly you can check if the name attribute was posted as well
                // if (isset($posted['name'])) {
                // $output = ''; // process as you need
                // }
                $out = Json::encode(['output'=>$output, 'message'=>'']);
            }
            return $out;
        }

        return $this->render('index', [
            'vehicleLayoutNameModel'=>$vehicleLayoutNameModel,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    protected function findModelVehicleLayoutNames($id)
    {
        if (($model = VehiclesLayoutsNames::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}