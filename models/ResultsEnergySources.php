<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ResultsEnergySources".
 *
 * @property int $id
 * @property int $vehicleLayoutName_id
 * @property int $architectureName_id
 * @property int $flightMode_id
 * @property int $energySource_id
 * @property double $Qpump Q нас
 * @property double $Qdisposable Q распол
 * @property double $P_pump_out P нас вых
 * @property double $Q_curr_to_Q_max Qтек/Qmax
 * @property double $N_pump_out N нас вых
 * @property double $N_pump_in N нас вх
 * @property double $N_consumers_in_hydro Nпотр_вх_гс
 * @property double $N_consumers_out Nпотр_вых
 * @property double $N_electric_total Nэс_всего
 * @property double $N_takeoff Nотбора
 *
 * @property ArchitecturesNames $architectureName
 * @property EnergySources $energySource
 * @property FlightModes $flightMode
 * @property VehiclesLayoutsNames $vehicleLayoutName
 */
class ResultsEnergySources extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ResultsEnergySources';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicleLayoutName_id', 'architectureName_id', 'flightMode_id', 'energySource_id'], 'required'],
            [['vehicleLayoutName_id', 'architectureName_id', 'flightMode_id', 'energySource_id'], 'integer'],
            [['Qpump', 'Qdisposable', 'P_pump_out', 'Q_curr_to_Q_max', 'N_pump_out', 'N_pump_in', 'N_consumers_in_hydro', 'N_consumers_out', 'N_electric_total', 'N_takeoff'], 'number'],
            [['architectureName_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchitecturesNames::className(), 'targetAttribute' => ['architectureName_id' => 'id']],
            [['energySource_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnergySources::className(), 'targetAttribute' => ['energySource_id' => 'id']],
            [['flightMode_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlightModes::className(), 'targetAttribute' => ['flightMode_id' => 'id']],
            [['vehicleLayoutName_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehiclesLayoutsNames::className(), 'targetAttribute' => ['vehicleLayoutName_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicleLayoutName_id' => 'Vehicle Layout Name ID',
            'architectureName_id' => 'Architecture Name ID',
            'flightMode_id' => 'Flight Mode ID',
            'energySource_id' => 'Энергосистема',
            'Qpump' => 'Q нас',
            'Qdisposable' => 'Q распол',
            'P_pump_out' => 'P нас вых',
            'Q_curr_to_Q_max' => 'Qтек/Qmax',
            'N_pump_out' => 'N нас вых',
            'N_pump_in' => 'N нас вх',
            'N_consumers_in_hydro' => 'Nпотр_вх_гс',
            'N_consumers_out' => 'Nпотр_вых',
            'N_electric_total' => 'Nэс_всего',
            'N_takeoff' => 'Nотбора',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchitectureName()
    {
        return $this->hasOne(ArchitecturesNames::className(), ['id' => 'architectureName_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEnergySource()
    {
        return $this->hasOne(EnergySources::className(), ['id' => 'energySource_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFlightMode()
    {
        return $this->hasOne(FlightModes::className(), ['id' => 'flightMode_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleLayoutName()
    {
        return $this->hasOne(VehiclesLayoutsNames::className(), ['id' => 'vehicleLayoutName_id']);
    }
}
