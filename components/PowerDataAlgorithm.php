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

    $constants = [
        'useQ0' => $useQ0,                                      // Учитывать Qo
    ]

    $results = [
        'consumers' => [
            $id => [
                $architectureID => [
                    $flightModeID => [
                        'consumption' => $consumption,
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

    public $constants = [];

    public $results = [];

    public function welcome()
    {
        VarDumper::dump( $this->consumers, $depth = 10, $highlight = true);
    }


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
        
        $this->results['consumers'][$consumerID][$architectureID][$flightModeID] = $consumption;
    }
}
?>