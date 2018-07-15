<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "Consumers".
 *
 * @property string $id
 * @property string $name Название потребителя ["Закрылки лев."]
 * @property int $aircraftPart_id
 * @property int $consumerGroup_id
 * @property double $efficiencyHydro КПД гидро
 * @property double $efficiencyElectric КПД электро
 * @property double $q0 Q0
 * @property double $qMax Q потр
 *
 * @property AircraftParts $aircraftPart
 * @property VehicleLayout[] $vehicleLayouts
 */
class Consumers extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'Consumers';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['aircraftPart_id', 'consumerGroup_id'], 'integer'],
            [['efficiencyHydro', 'efficiencyElectric', 'q0', 'qMax'], 'required'],
            [['efficiencyHydro', 'efficiencyElectric', 'q0', 'qMax'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['aircraftPart_id'], 'exist', 'skipOnError' => true, 'targetClass' => AircraftParts::className(), 'targetAttribute' => ['aircraftPart_id' => 'id']],
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
            'aircraftPart_id' => 'Зона аппарата',
            'consumerGroup_id' => 'Группа потребителей',
            'efficiencyHydro' => 'КПД гидро',
            'efficiencyElectric' => 'КПД электро',
            'q0' => 'Q0',
            'qMax' => 'Q max',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAircraftPart()
    {
        return $this->hasOne(AircraftParts::className(), ['id' => 'aircraftPart_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVehicleLayouts()
    {
        return $this->hasMany(VehicleLayout::className(), ['consumer_id' => 'id']);
    }
}
