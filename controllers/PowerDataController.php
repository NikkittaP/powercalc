<?php

namespace app\controllers;

use Yii;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

use \app\models\AircraftParts;
use \app\models\ArchitecturesNames;
use \app\models\ArchitectureToVehicleLayout;
use \app\models\EnergySources;
use \app\models\FlightModes;
use \app\models\FlightModesToVehicleLayout;
use \app\models\ResultsConsumers;
use \app\models\ResultsEnergySources;
use \app\models\VehicleLayout;
use \app\models\VehicleLayoutSearch;
use \app\models\VehiclesLayoutsNames;

use app\components\PowerDataAlgorithm;

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
        $vehicleLayoutModel = new VehicleLayout();
        $vehicleLayoutModel->attributes();
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
                        if ($ArchitectureToVehicleLayoutModel === null)
                        {
                            $ArchitectureToVehicleLayoutModel = new ArchitectureToVehicleLayout();
                            $ArchitectureToVehicleLayoutModel->vehicleLayout_id = $VehicleLayoutModel->id;
                            $ArchitectureToVehicleLayoutModel->architectureName_id = $architectureName_id;
                        }

                        $ArchitectureToVehicleLayoutModel->energySource_id = ($value === '') ? null : $value;
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
            'vehicleLayoutModel'=>$vehicleLayoutModel,
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider
        ]);
    }

    public function actionCreate()
    {
        $model = new VehicleLayout();
        $model->attributes();

        $model->vehicleLayoutName_id = Yii::$app->request->post('vehicleLayoutName_id');
        $model->consumer_id = Yii::$app->request->post('VehicleLayout')['consumer_id'];

        $model->save();

        return $this->redirect(['index', 'vehicleLayoutName_id'=>$model->vehicleLayoutName_id]);
    }

    public function actionCalculate()
    {
        $vehicleLayoutName_id = Yii::$app->request->post('vehicleLayoutName_id');

        $algorithm = new PowerDataAlgorithm();
       
        $architectureModels = ArchitecturesNames::find()->where(['vehicleLayoutName_id' => $vehicleLayoutName_id])->all();
        foreach($architectureModels as $architectureModel)
        {
            $algorithm->addArchitecture($architectureModel->id, [
                'isBasic' => $architectureModel->isBasic,
            ]);
        }
        
        $flightModeModels = FlightModes::find()->all();
        foreach($flightModeModels as $flightModeModel)
        {
            $algorithm->addFlightMode($flightModeModel->id, [
                'reductionFactor' => $flightModeModel->reductionFactor,
            ]);
        }

        $usedEnergySourcesIDs = [];
        $vehicleLayoutModels = VehicleLayout::find()->where(['vehicleLayoutName_id'=>$vehicleLayoutName_id])->all();
        foreach($vehicleLayoutModels as $vehicleLayoutModel)
        {
            $energySourcePerArchitecture = [];
            foreach($vehicleLayoutModel->architectureToVehicleLayouts as $architectureToVehicleLayout)
            {
                $energySourcePerArchitecture[$architectureToVehicleLayout->architectureName_id] = $architectureToVehicleLayout->energySource_id;
                $usedEnergySourcesIDs[] = $architectureToVehicleLayout->energySource_id;
            }
            
            $usageFactorPerFlightMode = [];
            foreach($vehicleLayoutModel->flightModesToVehicleLayouts as $flightModesToVehicleLayout)
                $usageFactorPerFlightMode[$flightModesToVehicleLayout->flightMode_id] = $flightModesToVehicleLayout->usageFactor;
            
            $algorithm->addConsumer($vehicleLayoutModel->consumer_id, [
                'efficiencyHydro' => $vehicleLayoutModel->consumer->efficiencyHydro,
                'efficiencyElectric' => $vehicleLayoutModel->consumer->efficiencyElectric,
                'q0' => $vehicleLayoutModel->consumer->q0,
                'qMax' => $vehicleLayoutModel->consumer->qMax,
                'energySourcePerArchitecture' => $energySourcePerArchitecture,
                'usageFactorPerFlightMode' => $usageFactorPerFlightMode,
            ]);
        }

        $energySourceModels = EnergySources::findAll($usedEnergySourcesIDs);
        foreach($energySourceModels as $energySourceModel)
        {
            $algorithm->addEnergySource($energySourceModel->id, [
                'type' => $energySourceModel->energySourceType->id,
                'qMax' => $energySourceModel->qMax,
                'pumpPressureNominal' => $energySourceModel->pumpPressureNominal,
                'pumpPressureWorkQmax' => $energySourceModel->pumpPressureWorkQmax,
            ]);
        }

        $algorithm->setConstants([
            'useQ0' => 1,
            'efficiencyPipeline' => 0.94,
            'efficiencyDriveBox' => 0.94,
            'efficiencyElectricMotor' => 0.95,
            'efficiencyCables' => 0.98,
            'efficiencyGenerator' => 0.9,
            'Kat2bar' => 0.980665,
            'isEfficiencyFixed' => 1,
            'efficiencyPump' => 0.885,
        ]);

        
        $algorithm->calculate();

        $this->clearPreviousResults($vehicleLayoutName_id);
        $this->saveResults($vehicleLayoutName_id, $algorithm->getResults());

        return $this->redirect(['results', 'vehicleLayoutName_id'=>$vehicleLayoutName_id]);
    }

    public function actionResults($vehicleLayoutName_id)
    {
        $vehicleLayoutNameModel = $this->findModelVehicleLayoutNames($vehicleLayoutName_id);
        $flightModeModel = FlightModes::find()->all();
        $aircraftPartsModel = AircraftParts::find()->orderBy('name')->all();
        $energySourcesModel = EnergySources::find()->orderBy('name')->all();

        $basicArchitectureModel = ArrayHelper::map(
            ArchitecturesNames::find()
            ->where(['isBasic'=>1, 'vehicleLayoutName_id'=>$vehicleLayoutName_id])
            ->all(),
            'id', 'name');

        $selectedArchitectures = [key($basicArchitectureModel)];
        $post = \Yii::$app->request->post();
        if ($post['selected_architectures']!=null) {
            foreach ($post['selected_architectures'] as $key => $value) {
                $selectedArchitectures[] = (int)$value;
            }
        }
        $selectedArchitectures = array_unique($selectedArchitectures);

        $alternativeArchitecture =  ArrayHelper::map(
            ArchitecturesNames::find()
            ->where([
                'isBasic'=>0,
                'vehicleLayoutName_id'=>$vehicleLayoutName_id,
                'id'=>array_values($selectedArchitectures)
                ])
                ->all(),
                'id', 'name');
        $resultsConsumersBasicModels = ResultsConsumers::find()
            ->where([
                'vehicleLayoutName_id'=>$vehicleLayoutName_id,
                'architectureName_id'=>key($basicArchitectureModel)
                ])
                ->orderBy('flightMode_id')
                ->all();
        $resultsConsumersAlternativeModels = ResultsConsumers::find()
            ->where([
                'vehicleLayoutName_id'=>$vehicleLayoutName_id,
                'architectureName_id'=>array_values($selectedArchitectures)
                ])
                ->andWhere(['<>','architectureName_id',key($basicArchitectureModel)])
                ->all();
        $resultsEnergySourcesBasicModels = ResultsEnergySources::find()
            ->where([
                'vehicleLayoutName_id'=>$vehicleLayoutName_id,
                'architectureName_id'=>key($basicArchitectureModel)
                ])
                ->orderBy('flightMode_id')
                ->all();
        $resultsEnergySourcesAlternativeModels = ResultsEnergySources::find()
            ->where([
                'vehicleLayoutName_id'=>$vehicleLayoutName_id,
                'architectureName_id'=>array_values($selectedArchitectures)
                ])
                ->andWhere(['<>','architectureName_id',key($basicArchitectureModel)])
                ->all();

        $N_out_by_parts = [];
        foreach ($resultsConsumersBasicModels as $results) {
            if (!isset($N_out[$results->flightMode_id][$results->consumer->aircraftPart_id]))
                $N_out_by_parts[$results->flightMode_id][$results->consumer->aircraftPart_id] = 0.0;

            $N_out_by_parts[$results->flightMode_id][$results->consumer->aircraftPart_id] += $results->N_out;
        }

        $chart_data = [];
        $usedEnergySourcesInSelectedArchitectures = [];
        $data = ResultsEnergySources::find()
            ->where([
                'vehicleLayoutName_id'=>$vehicleLayoutName_id,
                'architectureName_id'=>array_values($selectedArchitectures)
                ])
            ->orderBy('flightMode_id')
            ->all();
        foreach ($data as $results) {
            if (!in_array($results->energySource_id, $usedEnergySourcesInSelectedArchitectures))
                $usedEnergySourcesInSelectedArchitectures[] = $results->energySource_id;

            if (!isset($chart_data[$results->architectureName_id][$results->flightMode_id]['Qpump']))
                $chart_data[$results->architectureName_id][$results->flightMode_id][$results->energySource_id]['Qpump'] = 0.0;
            if ($results->architectureName->isBasic && !isset($chart_data['basic'][$results->flightMode_id]['Qdisposable']))
                $chart_data['basic'][$results->flightMode_id]['Qdisposable'] = 0.0;

            $chart_data[$results->architectureName_id][$results->flightMode_id]['architectureName'] = $results->architectureName->name;
            $chart_data[$results->architectureName_id][$results->flightMode_id]['flightModeName'] = $results->flightMode->name;
            $chart_data[$results->architectureName_id][$results->flightMode_id][$results->energySource_id]['Qpump'] += $results->Qpump;
            if ($results->architectureName->isBasic)
                $chart_data['basic'][$results->flightMode_id]['Qdisposable'] += $results->Qdisposable;
        }

        return $this->render('results', [
            'vehicleLayoutNameModel' => $vehicleLayoutNameModel,
            'flightModeModel' => $flightModeModel,
            'aircraftPartsModel' => $aircraftPartsModel,
            'energySourcesModel' => $energySourcesModel,
            'basicArchitecture' => $basicArchitectureModel,
            'selectedArchitectures' => $selectedArchitectures,
            'usedEnergySourcesInSelectedArchitectures' => $usedEnergySourcesInSelectedArchitectures,
            'alternativeArchitectures' => $alternativeArchitecture,
            'resultsConsumersBasic' => $resultsConsumersBasicModels,
            'resultsConsumersAlternative' => $resultsConsumersAlternativeModels,
            'resultsEnergySourcesBasic' => $resultsEnergySourcesBasicModels,
            'resultsEnergySourcesAlternative' => $resultsEnergySourcesAlternativeModels,
            'N_out_by_parts' => $N_out_by_parts,
            'chart_data' => $chart_data,
        ]);
    }

    protected function clearPreviousResults($vehicleLayoutName_id)
    {
        ResultsConsumers::deleteAll(['vehicleLayoutName_id'=>$vehicleLayoutName_id]);
        ResultsEnergySources::deleteAll(['vehicleLayoutName_id'=>$vehicleLayoutName_id]);
    }

    protected function saveResults($vehicleLayoutName_id, $results)
    {
        foreach ($results['consumers'] as $consumer_id => $array1) {
           foreach ($array1 as $architecture_id => $array2) {
                foreach ($array2 as $flightMode_id => $data) {
                    $resultsConsumersModel = new ResultsConsumers();

                    $resultsConsumersModel->vehicleLayoutName_id = $vehicleLayoutName_id;
                    $resultsConsumersModel->consumer_id = $consumer_id;
                    $resultsConsumersModel->architectureName_id = $architecture_id;
                    $resultsConsumersModel->flightMode_id = $flightMode_id;
                    $resultsConsumersModel->consumption = $data['consumption'];
                    $resultsConsumersModel->P_in = $data['P_in'];
                    $resultsConsumersModel->N_in_hydro = $data['N_in_hydro'];
                    $resultsConsumersModel->N_out = $data['N_out'];
                    $resultsConsumersModel->N_in_electric = $data['N_in_electric'];

                    $resultsConsumersModel->save();
                }
           }
        }

        foreach ($results['energySources'] as $energySource_id => $array1) {
            foreach ($array1 as $architecture_id => $array2) {
                 foreach ($array2 as $flightMode_id => $data) {
                     $resultsEnergySourcesModel = new ResultsEnergySources();
 
                     $resultsEnergySourcesModel->vehicleLayoutName_id = $vehicleLayoutName_id;
                     $resultsEnergySourcesModel->energySource_id = $energySource_id;
                     $resultsEnergySourcesModel->architectureName_id = $architecture_id;
                     $resultsEnergySourcesModel->flightMode_id = $flightMode_id;
                     $resultsEnergySourcesModel->Qpump = $data['Qpump'];
                     $resultsEnergySourcesModel->Qdisposable = $data['Qdisposable'];
                     $resultsEnergySourcesModel->P_pump_out = $data['P_pump_out'];
                     $resultsEnergySourcesModel->Q_curr_to_Q_max = $data['Q_curr_to_Q_max'];
                     $resultsEnergySourcesModel->N_pump_out = $data['N_pump_out'];
                     $resultsEnergySourcesModel->N_pump_in = $data['N_pump_in'];
                     $resultsEnergySourcesModel->N_consumers_in_hydro = $data['N_consumers_in_hydro'];
                     $resultsEnergySourcesModel->N_consumers_out = $data['N_consumers_out'];
                     $resultsEnergySourcesModel->N_electric_total = $data['N_electric_total'];
                     $resultsEnergySourcesModel->N_takeoff = $data['N_takeoff'];
 
                     $resultsEnergySourcesModel->save();
                 }
            }
         }
    }

    protected function findModelVehicleLayoutNames($id)
    {
        if (($model = VehiclesLayoutsNames::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}