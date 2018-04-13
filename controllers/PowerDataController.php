<?php

namespace app\controllers;

use Yii;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\helpers\Json;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \app\models\ArchitectureToVehicleLayout;
use \app\models\FlightModesToVehicleLayout;
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

    public function is_in_array($keys, $string) 
    {
        foreach ($keys as $key) {
            if (stripos($key, $string) !== FALSE) {
                return true;
            }
        }
    }

    public function actionIndex($vehicleLayoutName_id)
    {
        $vehicleLayoutNameModel = $this->findModelVehicleLayoutNames($vehicleLayoutName_id);
        $searchModel = new VehicleLayoutSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, $vehicleLayoutName_id);

        if (Yii::$app->request->post('hasEditable')) {
            $rowId = Yii::$app->request->post('editableKey');
            $VehicleLayoutModel = VehicleLayout::findOne($rowId);

            $out = Json::encode(['output'=>'', 'message'=>'']);
            $posted = current($_POST['VehicleLayout']);
            $output = '';

            if (isset($posted['consumer_id']))
            {
                $post = ['VehicleLayout' => $posted];
                if ($VehicleLayoutModel->load($post)) {
                    $VehicleLayoutModel->save();
    
                    $output =  $VehicleLayoutModel->consumer_id;
                    $out = Json::encode(['output'=>$output, 'message'=>'']);
                }
            }

            if ($this->is_in_array(array_keys($posted), 'architectureToVehicleLayouts_'))
            {
                foreach ($posted as $key => $value)
                {
                    if (stripos($key, 'architectureToVehicleLayouts_') !== FALSE) {
                        $architectureName_id = explode('_', $key)[1];

                        $ArchitectureToVehicleLayoutModel = ArchitectureToVehicleLayout::findOne(['vehicleLayout_id' => $VehicleLayoutModel->id, 'architectureName_id' => $architectureName_id]);
                        if ($ArchitectureToVehicleLayoutModel==null)
                        {
                            $ArchitectureToVehicleLayoutModel = new ArchitectureToVehicleLayout();
                            $ArchitectureToVehicleLayoutModel->vehicleLayout_id = $VehicleLayoutModel->id;
                            $ArchitectureToVehicleLayoutModel->architectureName_id = $architectureName_id;
                        }

                        $ArchitectureToVehicleLayoutModel->energySource_id = $value;
                        $ArchitectureToVehicleLayoutModel->save();

                        $output =  $ArchitectureToVehicleLayoutModel->energySource_id;
                        $out = Json::encode(['output'=>$output, 'message'=>'']);
                    }
                }
            }

            if ($this->is_in_array(array_keys($posted), 'flightModesToVehicleLayout_'))
            {
                foreach ($posted as $key => $value)
                {
                    if (stripos($key, 'flightModesToVehicleLayout_') !== FALSE) {
                        $flightMode_id = explode('_', $key)[1];

                        $FlightModesToVehicleLayoutModel = FlightModesToVehicleLayout::findOne(['vehicleLayout_id' => $VehicleLayoutModel->id, 'flightMode_id' => $flightMode_id]);
                        if ($FlightModesToVehicleLayoutModel==null)
                        {
                            $FlightModesToVehicleLayoutModel = new FlightModesToVehicleLayout();
                            $FlightModesToVehicleLayoutModel->vehicleLayout_id = $VehicleLayoutModel->id;
                            $FlightModesToVehicleLayoutModel->flightMode_id = $flightMode_id;
                        }

                        $FlightModesToVehicleLayoutModel->usageFactor = $value;
                        $FlightModesToVehicleLayoutModel->save();

                        $output =  $FlightModesToVehicleLayoutModel->usageFactor;
                        $out = Json::encode(['output'=>$output, 'message'=>'']);
                    }
                }
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