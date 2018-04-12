<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ArchitecturesNames".
 *
 * @property string $id
 * @property string $vehicleLayoutName_id
 * @property string $name Название архитектуры для модели (компоновки) ["База", "БЭС1"]
 *
 * @property ArchitectureToVehicleLayout[] $architectureToVehicleLayouts
 * @property VehiclesLayoutsNames $vehicleLayoutName
 */
class ArchitecturesNames extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ArchitecturesNames';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vehicleLayoutName_id', 'name'], 'required'],
            [['vehicleLayoutName_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
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
            'vehicleLayoutName_id' => 'Компоновка',
            'name' => 'Название',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArchitectureToVehicleLayouts()
    {
        return $this->hasMany(ArchitectureToVehicleLayout::className(), ['architectureName_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleLayoutName()
    {
        return $this->hasOne(VehiclesLayoutsNames::className(), ['id' => 'vehicleLayoutName_id']);
    }
}
