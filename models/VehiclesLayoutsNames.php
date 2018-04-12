<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "VehiclesLayoutsNames".
 *
 * @property string $id
 * @property string $vehicle_id
 * @property string $name Название модели (компоновки) ["Базовая модель", "Детальная модель"]
 *
 * @property VehicleLayout[] $vehicleLayouts
 * @property Vehicles $vehicle
 */
class VehiclesLayoutsNames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'VehiclesLayoutsNames';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicle_id'], 'required'],
            [['vehicle_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['vehicle_id'], 'exist', 'skipOnError' => true, 'targetClass' => Vehicles::className(), 'targetAttribute' => ['vehicle_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'vehicle_id' => 'Аппарат',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleLayouts()
    {
        return $this->hasMany(VehicleLayout::className(), ['vehicleLayoutName_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicle()
    {
        return $this->hasOne(Vehicles::className(), ['id' => 'vehicle_id']);
    }
}
