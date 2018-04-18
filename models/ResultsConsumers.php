<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ResultsConsumers".
 *
 * @property int $id
 * @property int $vehicleLayoutName_id
 * @property int $architectureName_id
 * @property int $flightMode_id
 * @property double $consumption Расход
 * @property double $P_in Pin
 * @property double $N_in_hydro Nin_гс
 * @property double $N_out Nвых
 * @property double $N_in_electric Nin_эс
 *
 * @property ArchitecturesNames $architectureName
 * @property FlightModes $flightMode
 * @property VehiclesLayoutsNames $vehicleLayoutName
 */
class ResultsConsumers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ResultsConsumers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicleLayoutName_id', 'architectureName_id', 'flightMode_id'], 'required'],
            [['vehicleLayoutName_id', 'architectureName_id', 'flightMode_id'], 'integer'],
            [['consumption', 'P_in', 'N_in_hydro', 'N_out', 'N_in_electric'], 'number'],
            [['architectureName_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchitecturesNames::className(), 'targetAttribute' => ['architectureName_id' => 'id']],
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
            'consumption' => 'Расход',
            'P_in' => 'Pin',
            'N_in_hydro' => 'Nin_гс',
            'N_out' => 'Nвых',
            'N_in_electric' => 'Nin_эс',
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
