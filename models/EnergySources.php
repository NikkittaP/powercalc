<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "EnergySources".
 *
 * @property int $id
 * @property string $name Название источника энергии ["ГС1", "ЛГС3", "ЭС1"]
 * @property int $energySourceType_id Является ли электросистемой
 *
 * @property ArchitectureToVehicleLayout[] $architectureToVehicleLayouts
 * @property EnergySourceToArchitecture[] $energySourceToArchitectures
 * @property EnergySourceToArchitecture[] $energySourceToArchitectures0
 * @property Energysourcetypes $energySourceType
 * @property ResultsEnergySources[] $resultsEnergySources
 */
class EnergySources extends \yii\db\ActiveRecord
{
    public $architectureAvailability;
    public $qMax;
    public $pumpPressureNominal;
    public $pumpPressureWorkQmax;
    public $NMax;
    public $energySourceLinked;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'EnergySources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'energySourceType_id'], 'required'],
            [['energySourceType_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['energySourceType_id'], 'exist', 'skipOnError' => true, 'targetClass' => Energysourcetypes::className(), 'targetAttribute' => ['energySourceType_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'energySourceType_id' => 'Тип энергосистемы',
            'architectureAvailability' => 'Архитектуры',
            'qMax' => 'Q max',
            'pumpPressureNominal' => 'Pнас ном',
            'pumpPressureWorkQmax' => 'Pнас раб при Qmax',
            'NMax' => 'N max',
            'energySourceLinked' => 'Энергопитание',
        ];
    }

    
    public function getArchitectureToVehicleLayouts()
    {
        return $this->hasMany(ArchitectureToVehicleLayout::className(), ['energySource_id' => 'id']);
    }
    public function getEnergySourceToArchitectures()
    {
        return $this->hasMany(EnergySourceToArchitecture::className(), ['energySource_id' => 'id']);
    }
    public function getEnergySourceToArchitecturesLinked()
    {
        return $this->hasMany(EnergySourceToArchitecture::className(), ['energySourceLinked_id' => 'id']);
    }
    public function getEnergySourceType()
    {
        return $this->hasOne(Energysourcetypes::className(), ['id' => 'energySourceType_id']);
    }
    public function getResultsEnergySources()
    {
        return $this->hasMany(ResultsEnergySources::className(), ['energySource_id' => 'id']);
    }
}
