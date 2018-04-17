<?php

namespace app\components;


use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use yii\helpers\VarDumper;
 
class PowerDataAlgorithm extends Component
{
    /*
    $consumers = [
        $id => [
            'efficiencyHydro' => $efficiencyHydro,          // КПД гидро
            'efficiencyElectric' => $efficiencyElectric,    // КПД электро
            'q0' => $q0,                                    // Q0
            'qMax' => $qMax,                                // Q потр

            'energySourcePerArchitecture' => [
                $architectureID => $energySourceID,         // Источник энергии для каждой из архитектур потребителя
            ],

            'usageFactorPerFlightMode' => [
                $flightModeID => $usageFactor,              // Коэффициент, который показывает на сколько исполнительный механизм задействован на каждом режиме полёта
            ],
        ]
    ];

    $energySources = [
        $id => [
            'isElectric' => $isElectric,                        // Является ли электросистемой
            'qMax' => $qMax,                                    // Qmax для расчёта Q располагаемого
            'pumpPressureNominal' => $pumpPressureNominal,      // Pнас ном
            'pumpPressureWorkQmax' => $pumpPressureWorkQmax,    // Pнас раб при Qmax
        ]
    ]

    $architectures = [
        $id => [
            'isBasic' => $isBasic,                              // Является ли базовой архитектурой
        ]
    ]

    $flightModes = [
        $id => [
            'reductionFactor' => $reductionFactor,              // Коэффициент понижения оборотов
        ]
    ]

    $constants = [
        'useQ0' => $useQ0,                                      // Учитывать Qo
        'efficiencyPipeline' => $efficiencyPipeline,            // КПД трубопровода
        'Kat2bar' => $Kat2bar,
        'isEfficiencyFixed' => $isEfficiencyFixed,              // КПД fix
        'efficiencyPump' =>$efficiencyPump,                     // КПД насоса для КПД fix
    ]

    $results = [
        'consumers' => [
            $id => [
                $architectureID => [
                    $flightModeID => [
                        'consumption' => $consumption,          // Расход
                        'P_in' => $P_in,                        // Pin
                        'N_in_hydro' => $N_in_hydro,            // Nin гс
                    ]
                ]
            ]
        ],
        'energySources' => [
            $id => [
                $architectureID => [
                    $flightModeID => [
                        'Qpump' => $Qpump,                      // Q нас
                        'Qdisposable' => $Qdisposable,          // Q распол
                        'P_pump_out' => $P_pump_out,            // P нас вых
                        'Q_curr_to_Q_max' => $Q_curr_to_Q_max,  // Qтек/Qmax
                        'N_pump_out' => $N_pump_out,            // N нас вых
                        'N_pump_in' => $N_pump_in,              // N нас вх
                    ]
                ]
            ]
        ]
    ]
    */
    public $consumers = [];
    public $energySources = [];
    public $architectures = [];
    public $architectureBasicID;
    public $flightModes = [];

    public $constants = [];

    public $results = [];

    /***********************************************************
    Инициализации
    ***********************************************************/

    /* Добавить источник энергии */
    public function addEnergySource($id, $data)
    {
       $this->energySources[$id] = $data;
    }
    /* Добавить архитектуру */
    public function addArchitecture($id, $data)
    {
       $this->architectures[$id] = $data;
       if ($data['isBasic']==1)
            $this->architectureBasicID = $id;
    }
    /* Добавить режим полета */
   public function addFlightMode($id, $data)
   {
      $this->flightModes[$id] = $data;
   }
    /* Добавить потребителя */
    public function addConsumer($id, $data)
    {
        $this->consumers[$id] = $data;
    }
     /* Задать константы */
     public function setConstants($data)
     {
         $this->constants = $data;
     }
     

    /***********************************************************
    Функции расчета параметров
    ***********************************************************/

    /* [0] Потребитель -> Расход */
    public function calcConsumerConsumption($consumerID, $architectureID, $flightModeID)
    {
        $consumer = $this->consumers[$consumerID];
        $energySourceBasic = $this->energySources[$consumer['energySourcePerArchitecture'][$this->architectureBasicID]];

        if ($consumer['usageFactorPerFlightMode'][$flightModeID]==0)
        {
            if ($energySourceBasic['isElectric']==1)
                $consumption = 0;
            else
                $consumption = $consumer['q0'] * $this->constants['useQ0'];
        } else {
            $consumption = $consumer['usageFactorPerFlightMode'][$flightModeID] * $consumer['qMax'];
        }
        
        $this->results['consumers'][$consumerID][$architectureID][$flightModeID]['consumption'] = $consumption;
    }

    /* [1] Архитектура -> Q нас */
    public function calcArchitectureQpump($energySourceID, $architectureID, $flightModeID)
    {
        $Qpump = 0;

        foreach ($this->results['consumers'] as $consumerID => $results) {
            if ($this->consumers[$consumerID]['energySourcePerArchitecture'][$architectureID]==$energySourceID)
                $Qpump += $results[$architectureID][$flightModeID]['consumption'];
        }

        $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Qpump'] = $Qpump;
    }
    /* [1] Архитектура -> Q распол */
    public function calcArchitectureQdisposable($energySourceID, $architectureID, $flightModeID)
    {
        $Qdisposable = $this->energySources[$energySourceID]['qMax'] * $this->flightModes[$flightModeID]['reductionFactor'];

        $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Qdisposable'] = $Qdisposable;
    }

     /* [2] Архитектура -> P нас вых */
    public function calcArchitectureP_pump_out($energySourceID, $architectureID, $flightModeID)
    {
        $Qpump = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Qpump'];
        $Qdisposable = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Qdisposable'];

        $P_pump_out = $this->energySources[$energySourceID]['pumpPressureNominal'] - 
            ($this->energySources[$energySourceID]['pumpPressureNominal'] - $this->energySources[$energySourceID]['pumpPressureWorkQmax'])
            /
            $Qdisposable
            *
            $Qpump;
 
        $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['P_pump_out'] = $P_pump_out;
    }
    /* [2] Архитектура -> Qтек/Qmax */
    public function calcArchitectureQ_curr_to_Q_max($energySourceID, $architectureID, $flightModeID)
    {
        $Qpump = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Qpump'];
        $Qdisposable = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Qdisposable'];
        
        $Q_curr_to_Q_max = $Qpump / $Qdisposable;

        $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Q_curr_to_Q_max'] = $Q_curr_to_Q_max;
    }

     /* [3] Потребитель -> Pin */
    public function calcConsumerP_in($consumerID, $architectureID, $flightModeID)
    {
        $consumer = $this->consumers[$consumerID];
        $energySourceBasicID = $consumer['energySourcePerArchitecture'][$this->architectureBasicID];
 
        $P_in = $this->results['energySources'][$energySourceBasicID][$architectureID][$flightModeID]['P_pump_out'] * $this->constants['efficiencyPipeline'];
         
        $this->results['consumers'][$consumerID][$architectureID][$flightModeID]['P_in'] = $P_in;
    }
    /* [3] Архитектура -> N нас вых */
    public function calcArchitectureN_pump_out($energySourceID, $architectureID, $flightModeID)
    {
        $P_pump_out = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['P_pump_out'];
        $Qpump = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Qpump'];
        
        $N_pump_out = $P_pump_out * $Qpump * (5.0 / 3.0) * $this->constants['Kat2bar'] / 1000.0;

        $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['N_pump_out'] = $N_pump_out;
    }

    /* [4] Потребитель -> Nin гс */
    public function calcConsumerN_in_hydro($consumerID, $architectureID, $flightModeID)
    {
        $P_in = $this->results['consumers'][$consumerID][$architectureID][$flightModeID]['P_in'];
        $consumption = $this->results['consumers'][$consumerID][$architectureID][$flightModeID]['consumption'];

        $N_in_hydro = $P_in * $consumption * (5.0 / 3.0) * $this->constants['Kat2bar'] / 1000.0;
        
        $this->results['consumers'][$consumerID][$architectureID][$flightModeID]['N_in_hydro'] = $N_in_hydro;
    }
    /* [4] Архитектура -> N нас вх */
    public function calcArchitectureN_pump_in($energySourceID, $architectureID, $flightModeID)
    {
        $N_pump_out = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['N_pump_out'];
        $Q_curr_to_Q_max = $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['Q_curr_to_Q_max'];

        if ($Q_curr_to_Q_max == 0)
            $N_pump_in = 0;
        else
        {
            if ($this->constants['isEfficiencyFixed']==1)
                $N_pump_in = $N_pump_out / $this->constants['efficiencyPump'];
            else
                $N_pump_in = $N_pump_out / $this->getInterpolatedEfficiencyPump($Q_curr_to_Q_max);
        }

        $this->results['energySources'][$energySourceID][$architectureID][$flightModeID]['N_pump_in'] = $N_pump_in;
    }

    /***********************************************************
    Основная функция расчёта
    ***********************************************************/
    public function calculate()
    {
        foreach ($this->flightModes as $flightModeID => $flightModeData) {
            foreach ($this->architectures as $architectureID => $architectureData) {
                /* [0] -------------------------------------------------------- */
                if ($architectureID==$this->architectureBasicID)
                    foreach ($this->consumers as $consumerID => $consumerData)
                        $this->calcConsumerConsumption($consumerID, $architectureID, $flightModeID);

                /* [1] -------------------------------------------------------- */
                foreach ($this->energySources as $energySourceID => $energySourceData)
                {
                    if ($this->isEnergySourceCorrespondToArchitecture($architectureID, $energySourceID))
                    {
                        $this->calcArchitectureQpump($energySourceID, $architectureID, $flightModeID);
                        $this->calcArchitectureQdisposable($energySourceID, $architectureID, $flightModeID);
                    }
                }

                /* [2] -------------------------------------------------------- */
                foreach ($this->energySources as $energySourceID => $energySourceData)
                {
                    if ($this->isEnergySourceCorrespondToArchitecture($architectureID, $energySourceID))
                    {
                        $this->calcArchitectureP_pump_out($energySourceID, $architectureID, $flightModeID);
                        $this->calcArchitectureQ_curr_to_Q_max($energySourceID, $architectureID, $flightModeID);
                    }
                }

                /* [3] -------------------------------------------------------- */
                if ($architectureID==$this->architectureBasicID)
                    foreach ($this->consumers as $consumerID => $consumerData)
                        $this->calcConsumerP_in($consumerID, $architectureID, $flightModeID);
                
                foreach ($this->energySources as $energySourceID => $energySourceData)
                    if ($this->isEnergySourceCorrespondToArchitecture($architectureID, $energySourceID))
                        $this->calcArchitectureN_pump_out($energySourceID, $architectureID, $flightModeID);

                /* [4] -------------------------------------------------------- */
                if ($architectureID==$this->architectureBasicID)
                    foreach ($this->consumers as $consumerID => $consumerData)
                        $this->calcConsumerN_in_hydro($consumerID, $architectureID, $flightModeID);
                
                foreach ($this->energySources as $energySourceID => $energySourceData)
                    if ($this->isEnergySourceCorrespondToArchitecture($architectureID, $energySourceID))
                        $this->calcArchitectureN_pump_in($energySourceID, $architectureID, $flightModeID);
            }
        }

        //VarDumper::dump( $this->results, $depth = 10, $highlight = true);
    }


    /***********************************************************
    Вспомогательные функции
    ***********************************************************/
    public function isEnergySourceCorrespondToArchitecture($architectureID, $energySourceID)
    {
        $isEnergySourceCorrespondToArchitecture = false;

        foreach ($this->consumers as $consumerID => $consumerData)
            foreach ($consumerData['energySourcePerArchitecture'] as $_architectureID => $_energySourceID) {
                if ($_architectureID == $architectureID && $_energySourceID == $energySourceID && $this->energySources[$_energySourceID]['isElectric'] == 0)
                    $isEnergySourceCorrespondToArchitecture = true;
            }
        
        return $isEnergySourceCorrespondToArchitecture;
    }

    /* Интерполяция КПД насоса для КПД _НЕ_ fix */
    public function getInterpolatedEfficiencyPump($Q_curr_to_Q_max)
    {
        return 0.885;
    }
}
?>