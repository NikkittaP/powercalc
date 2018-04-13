<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "FlightModes_to_VehicleLayout".
 *
 * @property string $id
 * @property string $vehicleLayout_id
 * @property string $flightMode_id
 * @property double $usageFactor На сколько задействован потребитель [0..1]
 *
 * @property FlightModes $flightMode
 * @property VehicleLayout $vehicleLayout
 */
class FlightModesToVehicleLayout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'FlightModes_to_VehicleLayout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicleLayout_id', 'flightMode_id'], 'required'],
            [['vehicleLayout_id', 'flightMode_id'], 'integer'],
            [['usageFactor'], 'number'],
            [['flightMode_id'], 'exist', 'skipOnError' => true, 'targetClass' => FlightModes::className(), 'targetAttribute' => ['flightMode_id' => 'id']],
            [['vehicleLayout_id'], 'exist', 'skipOnError' => true, 'targetClass' => VehicleLayout::className(), 'targetAttribute' => ['vehicleLayout_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicleLayout_id' => 'Vehicle Layout ID',
            'flightMode_id' => 'Flight Mode ID',
            'usageFactor' => 'Usage Factor',
        ];
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
    public function getVehicleLayout()
    {
        return $this->hasOne(VehicleLayout::className(), ['id' => 'vehicleLayout_id']);
    }
}
