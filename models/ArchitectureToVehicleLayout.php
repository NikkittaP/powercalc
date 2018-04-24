<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Architecture_to_VehicleLayout".
 *
 * @property int $id
 * @property int $vehicleLayout_id
 * @property int $architectureName_id
 * @property int $energySource_id
 *
 * @property ArchitecturesNames $architectureName
 * @property EnergySources $energySource
 * @property VehicleLayout $vehicleLayout
 */
class ArchitectureToVehicleLayout extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Architecture_to_VehicleLayout';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicleLayout_id', 'architectureName_id'], 'required'],
            [['vehicleLayout_id', 'architectureName_id', 'energySource_id'], 'integer'],
            [['architectureName_id'], 'exist', 'skipOnError' => true, 'targetClass' => ArchitecturesNames::className(), 'targetAttribute' => ['architectureName_id' => 'id']],
            [['energySource_id'], 'exist', 'skipOnError' => true, 'targetClass' => EnergySources::className(), 'targetAttribute' => ['energySource_id' => 'id']],
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
            'architectureName_id' => 'Architecture Name ID',
            'energySource_id' => 'Energy Source ID',
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
    public function getVehicleLayout()
    {
        return $this->hasOne(VehicleLayout::className(), ['id' => 'vehicleLayout_id']);
    }
}
